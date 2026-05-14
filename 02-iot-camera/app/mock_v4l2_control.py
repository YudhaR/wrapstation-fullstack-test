class V4L2Control:
    def __init__(self, device="/dev/video0"):
        self.device = device

    def set_control(self, name, value):
        print(f"[MOCK V4L2] {name}={value}")

    def reset_default(self):
        print("[MOCK V4L2] reset default")