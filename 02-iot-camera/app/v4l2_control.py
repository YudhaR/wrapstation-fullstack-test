import subprocess


class V4L2Control:
    def __init__(self, device="/dev/video0"):
        self.device = device

    def set_control(self, name, value):
        subprocess.run([
            "v4l2-ctl",
            "-d",
            self.device,
            "--set-ctrl",
            f"{name}={value}"
        ])

    def reset_default(self):
        self.set_control("brightness", 128)
        self.set_control("gain", 64)
        self.set_control("exposure_absolute", 300)