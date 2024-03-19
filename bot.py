import requests
import json
from datetime import datetime, timedelta

def send_discord_notification(webhook_url, embed):
    data = {
        "embeds": [embed]
    }
    headers = {
        "Content-Type": "application/json"
    }
    response = requests.post(webhook_url, data=json.dumps(data), headers=headers)
    if response.status_code == 204:
        print("Notifikasi berhasil dikirim ke Discord!")
    else:
        print("Gagal mengirim notifikasi ke Discord. Status code:", response.status_code)

# Ganti URL webhook dengan URL yang Anda dapatkan dari Discord
webhook_url = "https://discord.com/api/webhooks/1219772260131541033/GNs2TXrNREEbLAgTWozornPXAgJ-A7uRxJzu8_p15ojdd_cLAU2gtrCAvSzdf9Yh_98H"

# Mendapatkan waktu saat ini dan menambahkan 5 menit ke depan
waktu_restart = timedelta(minutes=5)
waktu_sekarang = datetime.now()
# Format waktu menjadi string yang sesuai
waktu_restart_str = (waktu_sekarang + waktu_restart).strftime("%H:%M")

# Membuat objek embed dengan waktu restart dan footer
embed = {
    "title": ":bell: Pemberitahuan Restart Server :bell:",
    "description": f"Server akan di-restart 5 Menit kedepan, pada pukul {waktu_restart_str} Server Time.",
    "color": 15158332,  # Warna merah
    "footer": {
        "text": f"Waktu sekarang: {waktu_sekarang.strftime('%Y-%m-%d %H:%M:%S')}"
    }
}

send_discord_notification(webhook_url, embed)
