import os
import time


def ensure_dir(path):
    os.makedirs(path, exist_ok=True)


def generate_filename(prefix, folder, ext="jpg"):
    ensure_dir(folder)
    timestamp = int(time.time())
    return f"{folder}/{prefix}_{timestamp}.{ext}"