# -*- coding: utf-8 -*-
"""Illustration of the citizen-facing (warga) dashboard of SIMPEDA,
based on the real beranda + riwayat-pengaduan views."""
import matplotlib
matplotlib.use("Agg")
import matplotlib.pyplot as plt
from matplotlib.patches import FancyBboxPatch, Rectangle
import os

OUT = os.path.dirname(os.path.abspath(__file__))
plt.rcParams["font.family"] = "DejaVu Sans"
BRAND = "#1a56db"
INK = "#1f2a44"


def rbox(ax, x, y, w, h, fc, ec="none", r=0.04, lw=0):
    ax.add_patch(FancyBboxPatch((x, y), w, h,
                 boxstyle=f"round,pad=0,rounding_size={r}",
                 fc=fc, ec=ec, lw=lw))


def gen():
    fig, ax = plt.subplots(figsize=(10.5, 7))
    ax.set_xlim(0, 10.5)
    ax.set_ylim(0, 7)
    ax.axis("off")
    ax.add_patch(Rectangle((0, 0), 10.5, 7, fc="#f1f5f9", ec="#cbd5e1", lw=1))

    # top navbar
    rbox(ax, 0, 6.5, 10.5, 0.5, "white", ec="#e2e8f0", lw=0.8, r=0.0)
    ax.text(0.35, 6.75, "SiMPeDa", fontsize=13, fontweight="bold", color=BRAND,
            va="center")
    for i, m in enumerate(["Beranda", "Pengaduan", "Lacak", "Pengumuman"]):
        ax.text(4.2 + i * 1.25, 6.75, m, fontsize=8.5, color="#475569",
                va="center", ha="center")
    rbox(ax, 9.45, 6.62, 0.85, 0.26, BRAND, r=0.05)
    ax.text(9.87, 6.75, "Akun ▾", fontsize=7.5, color="white", va="center",
            ha="center")

    # welcome banner
    rbox(ax, 0.3, 5.35, 9.9, 0.95, BRAND, r=0.06)
    ax.text(0.6, 6.02, "Selamat datang, Budi Santoso", fontsize=13,
            fontweight="bold", color="white", va="center")
    ax.text(0.6, 5.62, "Sampaikan keluhan dan aspirasi Anda kepada perangkat "
            "desa secara online.", fontsize=8.5, color="#dbeafe", va="center")

    # quick action cards
    actions = [("+  Buat Pengaduan", "#16a34a"),
               ("Lacak Pengaduan", "#2563eb"),
               ("Riwayat Saya", "#7c3aed")]
    for i, (label, col) in enumerate(actions):
        x = 0.3 + i * 3.37
        rbox(ax, x, 4.45, 3.17, 0.72, "white", ec="#e2e8f0", lw=0.8, r=0.05)
        rbox(ax, x + 0.18, 4.62, 0.38, 0.38, col, r=0.06)
        ax.text(x + 0.75, 4.81, label, fontsize=9.5, fontweight="bold",
                color=INK, va="center")

    # riwayat table card
    rbox(ax, 0.3, 0.35, 9.9, 3.85, "white", ec="#e2e8f0", lw=0.8, r=0.04)
    ax.text(0.6, 3.85, "Riwayat Pengaduan Saya", fontsize=11,
            fontweight="bold", color=INK, va="center")

    # header row
    rbox(ax, 0.55, 3.25, 9.4, 0.4, "#f8fafc", r=0.0)
    cols = [("No. Tiket", 0.75), ("Judul Pengaduan", 2.55),
            ("Status", 5.7), ("Tanggal", 7.35), ("", 8.9)]
    for c, cx in cols:
        ax.text(cx, 3.45, c, fontsize=8, fontweight="bold", color="#64748b",
                va="center")

    rows = [
        ("SPD-2026-0007", "Jalan rusak di RT 03 berlubang", "Selesai",
         "#dcfce7", "#15803d", "12 Jun 2026"),
        ("SPD-2026-0011", "Lampu jalan mati depan balai desa", "Diproses",
         "#dbeafe", "#1d4ed8", "10 Jun 2026"),
        ("SPD-2026-0014", "Sampah menumpuk di pasar desa", "Menunggu",
         "#fef3c7", "#b45309", "09 Jun 2026"),
    ]
    y = 2.78
    for tiket, judul, status, bg, fg, tgl in rows:
        rbox(ax, 0.65, y - 0.13, 1.55, 0.3, "#eff6ff", r=0.05)
        ax.text(0.75, y + 0.02, tiket, fontsize=7.6, color=BRAND,
                fontweight="bold", va="center", family="monospace")
        ax.text(2.55, y + 0.02, judul, fontsize=8.3, color=INK, va="center")
        rbox(ax, 5.6, y - 0.13, 1.15, 0.3, bg, r=0.08)
        ax.text(6.17, y + 0.02, status, fontsize=7.6, color=fg,
                fontweight="bold", va="center", ha="center")
        ax.text(7.35, y + 0.02, tgl, fontsize=7.8, color="#94a3b8",
                va="center")
        ax.text(8.9, y + 0.02, "Lihat Detail →", fontsize=7.8, color=BRAND,
                fontweight="bold", va="center")
        ax.plot([0.65, 9.85], [y - 0.28, y - 0.28], color="#f1f5f9", lw=0.8)
        y -= 0.72

    plt.tight_layout()
    fig.savefig(os.path.join(OUT, "dashboard_warga.png"), dpi=170,
                bbox_inches="tight", facecolor="white")
    plt.close(fig)
    print("OK dashboard_warga.png")


if __name__ == "__main__":
    gen()
