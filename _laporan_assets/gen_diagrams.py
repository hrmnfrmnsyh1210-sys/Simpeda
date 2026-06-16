# -*- coding: utf-8 -*-
"""Generate Use Case, ERD, and LRS diagrams for the SIMPEDA report.
Diagrams are derived directly from the Laravel migrations/models so they
match the actual system. Output: PNG files in the same folder.
"""
import matplotlib
matplotlib.use("Agg")
import matplotlib.pyplot as plt
from matplotlib.patches import FancyBboxPatch, Ellipse, Rectangle, FancyArrowPatch
import os

OUT = os.path.dirname(os.path.abspath(__file__))
plt.rcParams["font.family"] = "DejaVu Sans"

INK = "#1f2a44"
LINE = "#333333"


# ---------------------------------------------------------------------------
# 1. USE CASE DIAGRAM
# ---------------------------------------------------------------------------
def actor(ax, x, y, label):
    head = Ellipse((x, y + 0.42), 0.18, 0.18, fill=False, lw=1.6, ec=LINE)
    ax.add_patch(head)
    ax.plot([x, x], [y + 0.33, y - 0.05], color=LINE, lw=1.6)       # body
    ax.plot([x - 0.18, x + 0.18], [y + 0.22, y + 0.22], color=LINE, lw=1.6)  # arms
    ax.plot([x, x - 0.16], [y - 0.05, y - 0.32], color=LINE, lw=1.6)  # legs
    ax.plot([x, x + 0.16], [y - 0.05, y - 0.32], color=LINE, lw=1.6)
    ax.text(x, y - 0.55, label, ha="center", va="top", fontsize=10.5,
            fontweight="bold", color=INK)


def usecase(ax, x, y, label, w=2.55, h=0.62):
    e = Ellipse((x, y), w, h, fill=True, fc="#eef1f8", ec=LINE, lw=1.3)
    ax.add_patch(e)
    ax.text(x, y, label, ha="center", va="center", fontsize=9.2, color=INK)


def line(ax, p1, p2, style="-", color=LINE):
    ax.annotate("", xy=p2, xytext=p1,
                arrowprops=dict(arrowstyle="-", lw=1.1, ls=style, color=color))


def gen_usecase():
    fig, ax = plt.subplots(figsize=(11.5, 8.2))
    ax.set_xlim(0, 12)
    ax.set_ylim(0, 9)
    ax.axis("off")

    # system boundary
    ax.add_patch(Rectangle((3.2, 0.4), 5.6, 8.2, fill=False, lw=1.6, ec=LINE))
    ax.text(6.0, 8.35, "Sistem SIMPEDA", ha="center", va="center",
            fontsize=12, fontweight="bold", color=INK)

    # actors
    actor(ax, 1.5, 5.2, "Masyarakat")
    actor(ax, 10.5, 6.1, "Admin")
    actor(ax, 10.5, 2.3, "Superadmin")

    # masyarakat use cases (left column)
    m = [
        (5.0, 7.6, "Daftar Akun"),
        (5.0, 6.85, "Login"),
        (5.0, 6.1, "Buat Pengaduan"),
        (5.0, 5.35, "Lacak Pengaduan"),
        (5.0, 4.6, "Beri Rating & Ulasan"),
        (5.0, 3.85, "Lihat Riwayat Pengaduan"),
        (5.0, 3.1, "Lihat Pengumuman"),
    ]
    for x, y, lbl in m:
        usecase(ax, x, y, lbl)
        line(ax, (2.0, 5.2), (x - 1.28, y))

    # admin use cases (right column upper)
    a = [
        (7.0, 7.6, "Kelola Pengaduan"),
        (7.0, 6.85, "Perbarui Status"),
        (7.0, 6.1, "Beri Tanggapan"),
        (7.0, 5.35, "Kelola Pengumuman"),
        (7.0, 4.6, "Kelola Struktur Organisasi"),
        (7.0, 3.85, "Export Laporan PDF"),
    ]
    for x, y, lbl in a:
        usecase(ax, x, y, lbl)
        line(ax, (10.0, 6.1), (x + 1.28, y))

    # superadmin use cases (right column lower)
    s = [
        (7.0, 2.6, "Kelola Akun Pengguna"),
        (7.0, 1.85, "Lihat Log Aktivitas"),
        (7.0, 1.1, "Pengaturan Sistem"),
    ]
    for x, y, lbl in s:
        usecase(ax, x, y, lbl)
        line(ax, (10.0, 2.3), (x + 1.28, y))

    # superadmin inherits admin (generalization)
    ax.annotate("", xy=(10.5, 5.55), xytext=(10.5, 2.95),
                arrowprops=dict(arrowstyle="-|>", lw=1.3, color=LINE,
                                mutation_scale=18))
    ax.text(10.72, 4.25, "extends", fontsize=8, style="italic", color="#666")

    # <<include>> Login from key actions
    for (x, y) in [(5.0, 6.1), (5.0, 4.6)]:
        line(ax, (x, y + 0.31), (5.0, 6.85 - 0.31), style=(0, (4, 3)))
    ax.text(4.0, 6.5, "<<include>>", fontsize=7.5, style="italic", color="#888")

    plt.tight_layout()
    fig.savefig(os.path.join(OUT, "usecase.png"), dpi=170,
                bbox_inches="tight", facecolor="white")
    plt.close(fig)


# ---------------------------------------------------------------------------
# 2. ERD (Chen-style: entity = box, relationship = diamond)
# ---------------------------------------------------------------------------
def entity_box(ax, x, y, name, attrs, w=2.6):
    n = len(attrs)
    rh = 0.34
    total = rh * (n + 1)
    top = y + total / 2
    # header
    ax.add_patch(Rectangle((x - w / 2, top - rh), w, rh, fill=True,
                           fc="#2f3b66", ec=LINE, lw=1.2))
    ax.text(x, top - rh / 2, name, ha="center", va="center", color="white",
            fontsize=9.5, fontweight="bold")
    for i, (col, key) in enumerate(attrs):
        ry = top - rh * (i + 2)
        ax.add_patch(Rectangle((x - w / 2, ry), w, rh, fill=True,
                               fc="white", ec=LINE, lw=0.9))
        txt = col
        weight = "bold" if key in ("PK", "FK") else "normal"
        prefix = {"PK": "◆ ", "FK": "◇ "}.get(key, "")
        ax.text(x - w / 2 + 0.12, ry + rh / 2, prefix + txt, ha="left",
                va="center", fontsize=8, color=INK, fontweight=weight)
    return (x, top, top - total)  # center, top_y, bottom_y


def rel_diamond(ax, x, y, label, w=1.5, h=0.7):
    pts = [(x, y + h / 2), (x + w / 2, y), (x, y - h / 2), (x - w / 2, y)]
    ax.add_patch(plt.Polygon(pts, closed=True, fill=True, fc="#fde9c8",
                             ec=LINE, lw=1.1))
    ax.text(x, y, label, ha="center", va="center", fontsize=7.6, color=INK)


def connect(ax, p1, p2, card1="", card2=""):
    ax.annotate("", xy=p2, xytext=p1,
                arrowprops=dict(arrowstyle="-", lw=1.1, color=LINE))
    if card1:
        ax.text(p1[0], p1[1] + 0.16, card1, fontsize=8, color="#a33",
                ha="center", fontweight="bold")
    if card2:
        ax.text(p2[0], p2[1] + 0.16, card2, fontsize=8, color="#a33",
                ha="center", fontweight="bold")


def gen_erd():
    fig, ax = plt.subplots(figsize=(12, 8.6))
    ax.set_xlim(0, 13)
    ax.set_ylim(0, 9.2)
    ax.axis("off")

    users = entity_box(ax, 2.3, 5.2, "users",
                       [("id", "PK"), ("nik", ""), ("name", ""),
                        ("email", ""), ("password", ""), ("role", ""),
                        ("nomor_hp", ""), ("rt_rw", "")])
    pengaduans = entity_box(ax, 7.0, 5.2, "pengaduans",
                            [("id", "PK"), ("user_id", "FK"),
                             ("nomor_tiket", ""), ("kategori", ""),
                             ("status", ""), ("urgensi", ""),
                             ("judul", ""), ("deskripsi", "")])
    tanggapan = entity_box(ax, 11.2, 7.4, "tanggapan_pengaduans",
                           [("id", "PK"), ("pengaduan_id", "FK"),
                            ("user_id", "FK"), ("isi", "")])
    rating = entity_box(ax, 11.2, 3.2, "rating_pengaduans",
                        [("id", "PK"), ("pengaduan_id", "FK"),
                         ("bintang", ""), ("ulasan", "")])
    pengumuman = entity_box(ax, 2.3, 1.5, "pengumumans",
                            [("id", "PK"), ("user_id", "FK"),
                             ("judul", ""), ("status", "")])
    activity = entity_box(ax, 2.3, 8.2, "activity_logs",
                          [("id", "PK"), ("user_id", "FK"), ("action", "")])

    # relationships (diamonds) + cardinalities
    rel_diamond(ax, 4.65, 5.2, "membuat")
    connect(ax, (3.6, 5.2), (3.9, 5.2), card1="1")
    connect(ax, (5.4, 5.2), (5.7, 5.2), card2="M")

    rel_diamond(ax, 9.2, 6.3, "memiliki")
    connect(ax, (8.3, 5.7), (8.55, 6.1), card1="1")
    connect(ax, (9.85, 6.6), (10.0, 6.9), card2="M")

    rel_diamond(ax, 9.2, 4.1, "dinilai")
    connect(ax, (8.3, 4.7), (8.55, 4.3), card1="1")
    connect(ax, (9.85, 3.9), (10.0, 3.6), card2="1")

    rel_diamond(ax, 2.3, 3.3, "menulis")
    connect(ax, (2.3, 4.05), (2.3, 3.65), card1="1")
    connect(ax, (2.3, 2.95), (2.3, 2.4), card2="M")

    rel_diamond(ax, 2.3, 6.9, "mencatat")
    connect(ax, (2.3, 6.05), (2.3, 6.55), card1="1")
    connect(ax, (2.3, 7.25), (2.3, 7.6), card2="M")

    ax.text(6.5, 0.4,
            "Keterangan: ◆ = Primary Key   ◇ = Foreign Key   "
            "1:M = satu ke banyak   1:1 = satu ke satu",
            ha="center", fontsize=8.2, color="#555")

    plt.tight_layout()
    fig.savefig(os.path.join(OUT, "erd.png"), dpi=170,
                bbox_inches="tight", facecolor="white")
    plt.close(fig)


# ---------------------------------------------------------------------------
# 3. LRS (Logical Record Structure: tables with full attribute lists + FK links)
# ---------------------------------------------------------------------------
def lrs_table(ax, x, y, name, cols, w=2.7):
    rh = 0.3
    total = rh * (len(cols) + 1)
    top = y + total / 2
    ax.add_patch(Rectangle((x - w / 2, top - rh), w, rh, fill=True,
                           fc="#2f3b66", ec=LINE, lw=1.1))
    ax.text(x, top - rh / 2, name, ha="center", va="center", color="white",
            fontsize=9, fontweight="bold")
    anchors = {}
    for i, (col, key) in enumerate(cols):
        ry = top - rh * (i + 2)
        ax.add_patch(Rectangle((x - w / 2, ry), w, rh, fill=True,
                               fc="#f7f8fc" if key else "white", ec=LINE, lw=0.8))
        tag = f" ({key})" if key else ""
        weight = "bold" if key else "normal"
        ax.text(x - w / 2 + 0.1, ry + rh / 2, col + tag, ha="left",
                va="center", fontsize=7.7, color=INK, fontweight=weight)
        anchors[col] = (x - w / 2, ry + rh / 2, x + w / 2, ry + rh / 2)
    return anchors


def gen_lrs():
    fig, ax = plt.subplots(figsize=(12.5, 8.6))
    ax.set_xlim(0, 14)
    ax.set_ylim(0, 9.4)
    ax.axis("off")

    users = lrs_table(ax, 2.4, 5.0, "users", [
        ("id", "PK"), ("nik", ""), ("name", ""), ("email", ""),
        ("password", ""), ("role", ""), ("nomor_hp", ""),
        ("rt_rw", ""), ("is_active", "")])
    pengaduans = lrs_table(ax, 7.0, 5.2, "pengaduans", [
        ("id", "PK"), ("user_id", "FK"), ("nomor_tiket", ""),
        ("kategori", ""), ("nama_pelapor", ""), ("urgensi", ""),
        ("status", ""), ("judul", ""), ("deskripsi", ""), ("foto", "")])
    tanggapan = lrs_table(ax, 11.6, 7.6, "tanggapan_pengaduans", [
        ("id", "PK"), ("pengaduan_id", "FK"), ("user_id", "FK"),
        ("pengirim", ""), ("isi", "")])
    rating = lrs_table(ax, 11.6, 3.4, "rating_pengaduans", [
        ("id", "PK"), ("pengaduan_id", "FK"), ("bintang", ""),
        ("ulasan", "")])
    pengumuman = lrs_table(ax, 2.4, 1.3, "pengumumans", [
        ("id", "PK"), ("user_id", "FK"), ("judul", ""),
        ("slug", ""), ("status", "")])
    activity = lrs_table(ax, 2.4, 8.4, "activity_logs", [
        ("id", "PK"), ("user_id", "FK"), ("action", ""), ("target", "")])

    def fk_link(src_right, dst_left):
        ax.annotate("", xy=dst_left, xytext=src_right,
                    arrowprops=dict(arrowstyle="-|>", lw=1.2, color="#a33",
                                    connectionstyle="arc3,rad=0.12",
                                    mutation_scale=14))

    # users.id -> pengaduans.user_id
    fk_link((users["id"][2], users["id"][3]),
            (pengaduans["user_id"][0], pengaduans["user_id"][1]))
    # users.id -> pengumumans.user_id
    fk_link((users["id"][2], users["id"][3] - 0.1),
            (pengumuman["user_id"][0], pengumuman["user_id"][1]))
    # users.id -> activity_logs.user_id
    fk_link((users["id"][2], users["id"][3] + 0.1),
            (activity["user_id"][0], activity["user_id"][1]))
    # pengaduans.id -> tanggapan.pengaduan_id
    fk_link((pengaduans["id"][2], pengaduans["id"][3]),
            (tanggapan["pengaduan_id"][0], tanggapan["pengaduan_id"][1]))
    # pengaduans.id -> rating.pengaduan_id
    fk_link((pengaduans["id"][2], pengaduans["id"][3] - 0.1),
            (rating["pengaduan_id"][0], rating["pengaduan_id"][1]))

    ax.text(7.0, 0.3,
            "Keterangan: (PK) Primary Key   (FK) Foreign Key   "
            "panah merah = relasi foreign key antar tabel",
            ha="center", fontsize=8.2, color="#555")

    plt.tight_layout()
    fig.savefig(os.path.join(OUT, "lrs.png"), dpi=170,
                bbox_inches="tight", facecolor="white")
    plt.close(fig)


if __name__ == "__main__":
    gen_usecase()
    gen_erd()
    gen_lrs()
    print("OK - diagrams written to", OUT)
