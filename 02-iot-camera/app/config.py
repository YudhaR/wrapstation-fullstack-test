import platform

APP_TITLE = "Camera Control V4L2"
APP_SIZE = "1200x720"

IS_LINUX = platform.system() == "Linux"

CAMERA_INDEX = 0
CAMERA_DEVICE = "/dev/video0"

DEFAULT_WIDTH = 1280
DEFAULT_HEIGHT = 720

CAPTURE_KEY = "c"
BURST_KEY = "b"

OUTPUT_CAPTURE_DIR = "output/captures"
OUTPUT_BURST_DIR = "output/bursts"