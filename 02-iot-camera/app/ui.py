import cv2
import customtkinter as ctk
from PIL import Image

from app.config import (
    DEFAULT_WIDTH,
    DEFAULT_HEIGHT,
    OUTPUT_CAPTURE_DIR,
    OUTPUT_BURST_DIR,
)
from app.utils import generate_filename


class CameraControlUIWindows(ctk.CTkFrame):
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
        note = ctk.CTkLabel(
            self.panel,
            text=(
                "Catatan: Semua fitur kontrol kamera tersedia penuh di Linux dengan V4L2. "
                "Setiap kamera dapat memiliki pengaturan yang berbeda."
            ),
            wraplength=250,
            justify="left",
            text_color="gray"
        )
        note.pack(padx=16, pady=(0, 12), anchor="w")

        camera_values = [f"Camera {i}" for i in self.available_cameras] or ["No Camera"]

        self.add_label("Select Camera")
        self.camera_option = ctk.CTkOptionMenu(
            self.panel,
            values=camera_values,
            command=self.on_camera_change
        )
        self.camera_option.set(camera_values[0])
        self.camera_option.pack(padx=16, pady=(0, 12), fill="x")

        self.add_label("Resolution")
        self.resolution_option = ctk.CTkOptionMenu(
            self.panel,
            values=["640x480", "1280x720", "1920x1080"],
            command=self.on_resolution_change
        )
        self.resolution_option.set(f"{DEFAULT_WIDTH}x{DEFAULT_HEIGHT}")
        self.resolution_option.pack(padx=16, pady=(0, 12), fill="x")

        self.create_disabled_slider("Brightness: not available", 0, 255, 0)
        self.create_disabled_slider("Shutter / Exposure: not available", 1, 1000, 1)
        self.create_disabled_slider("ISO / Gain: not available", 0, 255, 0)

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

    def create_disabled_slider(self, label_text, from_value, to_value, default_value):
        self.add_label(label_text)

        slider = ctk.CTkSlider(
            self.panel,
            from_=from_value,
            to=to_value
        )
        slider.set(default_value)
        slider.configure(state="disabled")
        slider.pack(padx=16, pady=(0, 12), fill="x")

        return slider

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

            photo = ctk.CTkImage(
                light_image=image,
                dark_image=image,
                size=(800, 450)
            )

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

        actual_width = int(self.camera.cap.get(cv2.CAP_PROP_FRAME_WIDTH))
        actual_height = int(self.camera.cap.get(cv2.CAP_PROP_FRAME_HEIGHT))

        self.set_status(f"Resolution changed to {actual_width}x{actual_height}")

    def on_v4l2_change(self, name, value):
        self.set_status(f"{name} not available on Windows")

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
        self.set_status("Camera control reset is not available on Windows")

    def set_status(self, text):
        self.status_label.configure(text=f"Status: {text}")

    def release_camera(self):
        self.camera.release()

class CameraControlUILinux(ctk.CTkFrame):
    def __init__(self, master, camera, v4l2):
        super().__init__(master)

        self.camera = camera
        self.v4l2 = v4l2
        self.burst_active = False

        self.available_cameras = self.camera.get_available_cameras()

        self.slider_labels = {}

        self.grid_columnconfigure(0, weight=4)
        self.grid_columnconfigure(1, weight=1)
        self.grid_rowconfigure(0, weight=1)

        self.create_preview_area()
        self.create_control_panel()
        self.bind_keys()

        if self.available_cameras:
            index = self.available_cameras[0]
            self.camera.open(index)
            self.v4l2.set_device(index)
            self.v4l2.ensure_manual_controls()
            self.refresh_all_sliders()
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
        note = ctk.CTkLabel(
            self.panel,
            text=(
                "Catatan: Semua fitur kontrol kamera tersedia penuh di Linux dengan V4L2. "
                "Setiap kamera dapat memiliki pengaturan yang berbeda."
            ),
            wraplength=250,
            justify="left",
            text_color="gray"
        )
        note.pack(padx=16, pady=(0, 12), anchor="w")

        camera_values = [f"Camera {i}" for i in self.available_cameras]

        if not camera_values:
            camera_values = ["No Camera"]

        self.add_label("Select Camera")

        self.camera_option = ctk.CTkOptionMenu(
            self.panel,
            values=camera_values,
            command=self.on_camera_change
        )
        self.camera_option.set(camera_values[0])
        self.camera_option.pack(padx=16, pady=(0, 12), fill="x")

        self.add_label("Resolution")

        self.resolution_option = ctk.CTkOptionMenu(
            self.panel,
            values=["640x480", "1280x720", "1920x1080"],
            command=self.on_resolution_change
        )
        self.resolution_option.set(f"{DEFAULT_WIDTH}x{DEFAULT_HEIGHT}")
        self.resolution_option.pack(padx=16, pady=(0, 12), fill="x")

        self.brightness_slider = self.create_control_slider(
            label_text="Brightness",
            control_name="brightness"
        )

        self.exposure_slider = self.create_control_slider(
            label_text="Shutter / Exposure",
            control_name="exposure_time_absolute"
        )

        self.gain_slider = self.create_control_slider(
            label_text="ISO / Gain",
            control_name="gain"
        )

        self.focus_slider = self.create_control_slider(
            label_text="Focus",
            control_name="focus_absolute"
        )

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

    def create_control_slider(self, label_text, control_name):
        label = ctk.CTkLabel(
            self.panel,
            text=f"{label_text}: checking...",
            anchor="w"
        )
        label.pack(padx=16, pady=(8, 4), fill="x")

        slider = ctk.CTkSlider(
            self.panel,
            from_=0,
            to=100,
            command=lambda value: self.on_v4l2_change(control_name, value)
        )
        slider.pack(padx=16, pady=(0, 12), fill="x")
        slider.configure(state="disabled")

        self.slider_labels[control_name] = label

        return slider

    def configure_slider(self, slider, control_name, display_name):
        controls = self.v4l2.get_controls()
        label = self.slider_labels[control_name]

        if control_name not in controls:
            slider.configure(state="disabled")
            label.configure(text=f"{display_name}: not available")
            return

        control = controls[control_name]

        if control["inactive"]:
            slider.configure(state="disabled")
            label.configure(text=f"{display_name}: inactive / not available")
            return

        min_value = control["min"]
        max_value = control["max"]
        current_value = control["value"]

        if min_value > max_value:
            min_value, max_value = max_value, min_value

        slider.configure(
            from_=min_value,
            to=max_value,
            state="normal"
        )

        slider.set(current_value)

        label.configure(
            text=f"{display_name}: {current_value} "
                 f"(min {min_value}, max {max_value})"
        )

    def refresh_all_sliders(self):
        self.v4l2.ensure_manual_controls()

        self.configure_slider(
            self.brightness_slider,
            "brightness",
            "Brightness"
        )

        self.configure_slider(
            self.exposure_slider,
            "exposure_time_absolute",
            "Shutter / Exposure"
        )

        self.configure_slider(
            self.gain_slider,
            "gain",
            "ISO / Gain"
        )

        self.configure_slider(
            self.focus_slider,
            "focus_absolute",
            "Focus"
        )

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

            photo = ctk.CTkImage(
                light_image=image,
                dark_image=image,
                size=(800, 450)
            )

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
            self.v4l2.set_device(index)
            self.v4l2.ensure_manual_controls()
            self.refresh_all_sliders()
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
            f"Resolution changed to {actual_width}x{actual_height}"
        )

    def on_v4l2_change(self, name, value):
        value = int(value)

        success = self.v4l2.set_control(name, value)

        if success:
            if name in self.slider_labels:
                current_text = self.slider_labels[name].cget("text")
                base_text = current_text.split(":")[0]
                self.slider_labels[name].configure(
                    text=f"{base_text}: {value}"
                )

            self.set_status(f"{name} set to {value}")
        else:
            self.set_status(f"{name} not available")

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
        self.refresh_all_sliders()
        self.set_status("Camera reset")

    def set_status(self, text):
        self.status_label.configure(text=f"Status: {text}")

    def release_camera(self):
        self.camera.release()