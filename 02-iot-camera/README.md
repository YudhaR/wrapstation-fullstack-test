# IoT & Embedded Systems - Camera Control with OpenCV and V4L2

Project ini merupakan implementasi aplikasi Camera Control sederhana menggunakan OpenCV dan Video4Linux (V4L2) untuk mengakses, menampilkan, dan mengontrol kamera/webcam sesuai technical test dari Wrap Station Group.

Aplikasi dibangun menggunakan Python dan CustomTkinter sebagai GUI framework, dengan dukungan kontrol kamera menggunakan V4L2 (`v4l2-ctl`) pada Linux.

## Features

- Live Preview kamera secara realtime
- Select Camera / Multiple Camera Support
- Capture Image menggunakan tombol keyboard (`C`)
- Burst Capture menggunakan tombol keyboard (`B`)
- GUI menggunakan CustomTkinter
- Kontrol parameter kamera menggunakan V4L2:
  - Brightness
  - Shutter / Exposure
  - ISO / Gain
- Support pengaturan resolusi kamera
- Menyimpan hasil capture otomatis ke folder output
- Cross-platform development:
  - Windows untuk development UI
  - Linux untuk implementasi V4L2

---

# Technologies

- Python
- OpenCV
- CustomTkinter
- Pillow
- Video4Linux (V4L2)

---

# Project Structure

```bash
02-iot-camera/
│
├── app/
│   ├── __init__.py
│   ├── main.py
│   ├── ui.py
│   ├── camera.py
│   ├── v4l2_control.py
│   ├── mock_v4l2_control.py
│   ├── config.py
│   └── utils.py
│
├── output/
│   ├── captures/
│   └── bursts/
│
├── requirements.txt
├── README.md
└── run.py
```

---

# Setup Project

Masuk ke folder project:

```bash
cd 02-iot-camera
```

Buat virtual environment:

```bash
python -m venv venv
```

Aktifkan virtual environment:

Linux:

```bash
source venv/bin/activate
```

Install dependencies:

```bash
pip install -r requirements.txt
```

---

# Linux Setup (V4L2)

Install V4L2 utilities:

```bash
sudo apt install v4l-utils
```

Cek daftar kamera:

```bash
v4l2-ctl --list-devices
```

Cek camera controls:

```bash
v4l2-ctl --list-ctrls
```

Cek resolusi kamera yang tersedia:

```bash
v4l2-ctl --list-formats-ext
```

---

# Run Application

Jalankan aplikasi:

```bash
python run.py
```

---

# Key Mapping

| Key | Function |
|---|---|
| C | Capture Image |
| B | Burst Capture |
| Q | Quit Application |

---

# Output Structure

Hasil single capture akan disimpan pada folder:

```bash
output/captures/
```

Hasil burst capture akan disimpan pada folder:

```bash
output/bursts/
```

---

# Camera Controls

Aplikasi mendukung kontrol kamera menggunakan V4L2 pada Linux:

- Brightness
- Exposure / Shutter Speed
- ISO / Gain

Catatan:
Setiap webcam memiliki capability berbeda-beda tergantung driver dan hardware kamera.

---

# Notes

- Development UI dilakukan menggunakan Windows.
- Kontrol hardware kamera menggunakan V4L2 dijalankan pada Linux.
- Disarankan menggunakan webcam asli atau webcam USB eksternal saat pengujian di Linux.

---

# Requirements

Isi file `requirements.txt`:

```txt
opencv-python
customtkinter
pillow
numpy
```