import subprocess


class V4L2Control:
    def __init__(self, device="/dev/video0"):
        self.device = device

    def set_control(self, name, value):
        command = [
            "v4l2-ctl",
            "-d",
            self.device,
            "--set-ctrl",
            f"{name}={int(value)}"
        ]

        print("Running:", " ".join(command))

        result = subprocess.run(command, capture_output=True, text=True)

        if result.returncode != 0:
            print(result.stderr.strip())

    def reset_default(self):
        self.set_control("brightness", 128)
        self.set_control("gain", 64)
        self.set_control("exposure_absolute", 300)