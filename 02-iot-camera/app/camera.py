import cv2
import time
import platform


class CameraManager:
    def __init__(self, index=0, width=1280, height=720):
        self.index = index
        self.width = width
        self.height = height
        self.cap = None
        self.is_linux = platform.system() == "Linux"

    def get_available_cameras(self, max_index=10):
        cameras = []

        for index in range(max_index):
            cap = self._create_capture(index)

            if cap.isOpened():
                ret, _ = cap.read()
                if ret:
                    cameras.append(index)

            cap.release()

        return cameras

    def _create_capture(self, index):
        if self.is_linux:
            return cv2.VideoCapture(index, cv2.CAP_V4L2)

        return cv2.VideoCapture(index)

    def open(self, index=None):
        if index is not None:
            self.index = index

        self.release()

        self.cap = self._create_capture(self.index)

        if not self.cap.isOpened():
            return False

        if not self.is_linux:
            self.cap.set(
                cv2.CAP_PROP_FOURCC,
                cv2.VideoWriter_fourcc(*"MJPG")
            )

        self.cap.set(cv2.CAP_PROP_FRAME_WIDTH, self.width)
        self.cap.set(cv2.CAP_PROP_FRAME_HEIGHT, self.height)

        time.sleep(0.3)

        actual_width = int(self.cap.get(cv2.CAP_PROP_FRAME_WIDTH))
        actual_height = int(self.cap.get(cv2.CAP_PROP_FRAME_HEIGHT))

        print(f"Requested: {self.width}x{self.height}")
        print(f"Actual: {actual_width}x{actual_height}")

        return True

    def read(self):
        if self.cap is None or not self.cap.isOpened():
            return False, None

        return self.cap.read()

    def set_resolution(self, width, height):
        self.width = width
        self.height = height

        if self.cap is not None:
            self.open(self.index)

    def capture(self, filename):
        ret, frame = self.read()

        if not ret:
            return False

        print("Captured shape:", frame.shape)
        cv2.imwrite(filename, frame)
        return True

    def release(self):
        if self.cap is not None:
            self.cap.release()
            self.cap = None