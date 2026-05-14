import customtkinter as ctk

from app.config import APP_TITLE, APP_SIZE, IS_LINUX, CAMERA_DEVICE, CAMERA_INDEX, DEFAULT_WIDTH, DEFAULT_HEIGHT
from app.camera import CameraManager


if IS_LINUX:
    from app.v4l2_control import V4L2Control
    from app.ui import CameraControlUILinux as CameraControlUI
else:
    from app.mock_v4l2_control import V4L2Control
    from app.ui import CameraControlUIWindows as CameraControlUI


class App(ctk.CTk):
    def __init__(self):
        super().__init__()

        self.title(APP_TITLE)
        self.geometry(APP_SIZE)

        ctk.set_appearance_mode("dark")
        ctk.set_default_color_theme("blue")

        self.camera = CameraManager(
            index=CAMERA_INDEX,
            width=DEFAULT_WIDTH,
            height=DEFAULT_HEIGHT
        )

        self.v4l2 = V4L2Control(device=CAMERA_DEVICE)

        self.ui = CameraControlUI(
            master=self,
            camera=self.camera,
            v4l2=self.v4l2
        )
        self.ui.pack(fill="both", expand=True)

        self.protocol("WM_DELETE_WINDOW", self.on_close)

    def on_close(self):
        self.ui.release_camera()
        self.destroy()