from ultralytics import YOLO
import cv2
import os

MODEL_PATH = "runs/train/yolo11_fruits/weights/best.pt"
IMAGE_PATH = "dataset/test/images/Image_7_jpg.rf.c09b5cb2245ab71680ee93bf2191556b.jpg"

CONFIDENCE_THRESHOLD = 0.25
WINDOW_NAME = "Fruit Detection - YOLO"

if not os.path.exists(MODEL_PATH):
    raise FileNotFoundError(f"Model tidak ditemukan: {MODEL_PATH}")

if not os.path.exists(IMAGE_PATH):
    raise FileNotFoundError(f"Gambar tidak ditemukan: {IMAGE_PATH}")

model = YOLO(MODEL_PATH)

image = cv2.imread(IMAGE_PATH)

if image is None:
    raise ValueError("Gambar gagal dibaca. Pastikan format gambar valid.")

results = model.predict(
    source=image,
    conf=CONFIDENCE_THRESHOLD,
    verbose=False
)

for result in results:
    boxes = result.boxes

    for box in boxes:
        x1, y1, x2, y2 = box.xyxy[0].cpu().numpy().astype(int)
        confidence = float(box.conf[0])
        class_id = int(box.cls[0])
        class_name = model.names[class_id]

        label = f"{class_name} {confidence:.2f}"

        cv2.rectangle(
            image,
            (x1, y1),
            (x2, y2),
            (0, 255, 0),
            2
        )

        cv2.putText(
            image,
            label,
            (x1, y1 - 10),
            cv2.FONT_HERSHEY_SIMPLEX,
            0.7,
            (0, 255, 0),
            2
        )

cv2.imshow(WINDOW_NAME, image)

print("Tekan tombol apa saja pada window gambar untuk menutup program.")
cv2.waitKey(0)
cv2.destroyAllWindows()