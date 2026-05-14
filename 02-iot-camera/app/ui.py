import cv2
import customtkinter as ctk
from PIL import Image, ImageTk

from app.config import (
    DEFAULT_WIDTH,
    DEFAULT_HEIGHT,
    OUTPUT_CAPTURE_DIR,
    OUTPUT_BURST_DIR,
)
from app.utils import generate_filename


class CameraControlUI(ctk.CTkFrame):
    def __init__(self, master, camera, v4l2):
        super().__init__(master)

        self.camera = camera
        self.v4l2 = v4l2

        self.burst_active = False

        self.available_cameras = self.camera.get_available_cameras()

        self.grid_columnconfigure(0, weight=4)
        self.grid_columnconfigure(1, weight=1)
        self.grid_rowconfigure(0, weight=1)

        self.create_preview_area()
        self.create_control_panel()
        self.bind_keys()

        if self.available_cameras:
            index = self.available_cameras[0]
            self.camera.open(index)
            self.v4l2.device = f"/dev/video{index}"
            self.set_status(f"Camera {index} opened")
        else:
            self.set_status("No camera detected")

        self.update_camera()

    def create_preview_area(self):
        self.preview_label = ctk.CTkLabel(
            self,
            text="Live Preview",
            font=ctk.CTkFont(size=20, weight="bold")
        )
        self.preview_label.grid(row=0, column=0, padx=16, pady=16, sticky="nsew")

    def create_control_panel(self):
        self.panel = ctk.CTkFrame(self)
        self.panel.grid(row=0, column=1, padx=16, pady=16, sticky="nsew")

        title = ctk.CTkLabel(
            self.panel,
            text="Camera Control",
            font=ctk.CTkFont(size=20, weight="bold")
        )
        title.pack(padx=16, pady=(20, 12), anchor="w")

        camera_values = [f"Camera {i}" for i in self.available_cameras]

        if not camera_values:
            camera_values = ["No Camera"]

        self.camera_option = ctk.CTkOptionMenu(
            self.panel,
            values=camera_values,
            command=self.on_camera_change
        )
        self.camera_option.set(camera_values[0])
        self.add_label("Select Camera")
        self.camera_option.pack(padx=16, pady=(0, 12), fill="x")

        self.resolution_option = ctk.CTkOptionMenu(
            self.panel,
            values=["640x480", "1280x720", "1920x1080"],
            command=self.on_resolution_change
        )
        self.resolution_option.set(f"{DEFAULT_WIDTH}x{DEFAULT_HEIGHT}")
        self.add_label("Resolution")
        self.resolution_option.pack(padx=16, pady=(0, 12), fill="x")

        self.add_label("Brightness")
        self.brightness_slider = ctk.CTkSlider(
            self.panel,
            from_=0,
            to=255,
            command=lambda value: self.on_v4l2_change("brightness", value)
        )
        self.brightness_slider.set(128)
        self.brightness_slider.pack(padx=16, pady=(0, 12), fill="x")

        self.add_label("Shutter / Exposure")
        self.exposure_slider = ctk.CTkSlider(
            self.panel,
            from_=1,
            to=1000,
            command=lambda value: self.on_v4l2_change("exposure_time_absolute", value)
        )
        self.exposure_slider.set(300)
        self.exposure_slider.pack(padx=16, pady=(0, 12), fill="x")

        self.add_label("ISO / Gain")
        self.gain_slider = ctk.CTkSlider(
            self.panel,
            from_=0,
            to=255,
            command=lambda value: self.on_v4l2_change("gain", value)
        )
        self.gain_slider.set(64)
        self.gain_slider.pack(padx=16, pady=(0, 12), fill="x")

        self.capture_button = ctk.CTkButton(
            self.panel,
            text="Capture Image (C)",
            command=self.capture_image
        )
        self.capture_button.pack(padx=16, pady=(20, 8), fill="x")

        self.burst_button = ctk.CTkButton(
            self.panel,
            text="Hold B for Burst Capture",
        )
        self.burst_button.pack(padx=16, pady=8, fill="x")

        self.reset_button = ctk.CTkButton(
            self.panel,
            text="Reset Camera",
            fg_color="gray",
            command=self.reset_camera
        )
        self.reset_button.pack(padx=16, pady=8, fill="x")

        self.status_label = ctk.CTkLabel(
            self.panel,
            text="Status: Ready",
            wraplength=250
        )
        self.status_label.pack(padx=16, pady=(20, 8), fill="x")

    def add_label(self, text):
        label = ctk.CTkLabel(self.panel, text=text, anchor="w")
        label.pack(padx=16, pady=(8, 4), fill="x")

    def bind_keys(self):
        self.master.bind("<KeyPress-c>", lambda event: self.capture_image())
        self.master.bind("<KeyPress-C>", lambda event: self.capture_image())

        self.master.bind("<KeyPress-b>", self.start_burst)
        self.master.bind("<KeyRelease-b>", self.stop_burst)

        self.master.bind("<KeyPress-B>", self.start_burst)
        self.master.bind("<KeyRelease-B>", self.stop_burst)

    def update_camera(self):
        ret, frame = self.camera.read()

        if ret:
            frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

            image = Image.fromarray(frame)
            image = image.resize((800, 450))

            photo = ImageTk.PhotoImage(image)

            self.preview_label.configure(image=photo, text="")
            self.preview_label.image = photo
        else:
            self.preview_label.configure(text="Failed to read camera")

        self.after(15, self.update_camera)

    def on_camera_change(self, value):
        if value == "No Camera":
            self.set_status("No camera available")
            return

        index = int(value.split(" ")[1])

        if self.camera.open(index):
            self.v4l2.device = f"/dev/video{index}"
            self.set_status(f"Camera {index} opened")
        else:
            self.set_status(f"Failed to open Camera {index}")

    def on_resolution_change(self, value):
        width, height = map(int, value.split("x"))

        current_index = self.camera.index

        self.camera.release()

        self.camera.width = width
        self.camera.height = height

        self.camera.open(current_index)

        actual_width = int(
            self.camera.cap.get(cv2.CAP_PROP_FRAME_WIDTH)
        )

        actual_height = int(
            self.camera.cap.get(cv2.CAP_PROP_FRAME_HEIGHT)
        )

        self.set_status(
            f"Resolution changed to "
            f"{actual_width}x{actual_height}"
        )

    def on_v4l2_change(self, name, value):
        value = int(value)
        self.v4l2.set_control(name, value)
        self.set_status(f"{name} set to {value}")

    def capture_image(self):
        filename = generate_filename("capture", OUTPUT_CAPTURE_DIR)

        if self.camera.capture(filename):
            self.set_status(f"Image saved: {filename}")
        else:
            self.set_status("Failed to capture image")

    def start_burst(self, event=None):
        if self.burst_active:
            return

        self.burst_active = True
        self.set_status("Burst capture started")
        self.run_burst()

    def run_burst(self):
        if not self.burst_active:
            return

        filename = generate_filename("burst", OUTPUT_BURST_DIR)
        self.camera.capture(filename)

        self.after(200, self.run_burst)

    def stop_burst(self, event=None):
        self.burst_active = False
        self.set_status("Burst capture stopped")

    def reset_camera(self):
        self.v4l2.reset_default()
        self.set_status("Camera reset")

    def set_status(self, text):
        self.status_label.configure(text=f"Status: {text}")

    def release_camera(self):
        self.camera.release()