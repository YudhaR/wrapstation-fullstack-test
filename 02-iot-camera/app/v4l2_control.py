import subprocess
import re


class V4L2Control:
    def __init__(self, device="/dev/video0"):
        self.device = device

    def set_device(self, index):
        self.device = f"/dev/video{index}"

    def set_control(self, name, value):
        result = subprocess.run(
            [
                "v4l2-ctl",
                "-d",
                self.device,
                "--set-ctrl",
                f"{name}={int(value)}"
            ],
            capture_output=True,
            text=True
        )

        if result.returncode != 0:
            print(result.stderr.strip())
            return False

        return True

    def get_controls(self):
        result = subprocess.run(
            [
                "v4l2-ctl",
                "-d",
                self.device,
                "--list-ctrls"
            ],
            capture_output=True,
            text=True
        )

        controls = {}

        for line in result.stdout.splitlines():
            match = re.search(
                r"(\w+)\s+0x[0-9a-f]+.*min=(-?\d+)\s+max=(-?\d+).*default=(-?\d+)\s+value=(-?\d+)(.*)",
                line
            )

            if match:
                name = match.group(1)

                controls[name] = {
                    "min": int(match.group(2)),
                    "max": int(match.group(3)),
                    "default": int(match.group(4)),
                    "value": int(match.group(5)),
                    "inactive": "inactive" in match.group(6)
                }

        return controls

    def ensure_manual_controls(self):
        controls = self.get_controls()

        if "auto_exposure" in controls:
            self.set_control("auto_exposure", 1)

        if "focus_automatic_continuous" in controls:
            self.set_control("focus_automatic_continuous", 0)

    def reset_default(self):
        self.ensure_manual_controls()

        controls = self.get_controls()

        for name, control in controls.items():
            if control["inactive"]:
                continue

            if name in ["brightness", "gain", "exposure_time_absolute", "focus_absolute"]:
                self.set_control(name, control["default"])