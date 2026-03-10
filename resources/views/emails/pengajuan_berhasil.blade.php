<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Pengajuan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;">
    <div style="background-color: white; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; border-top: 5px solid #195c2e;">
        <h2 style="color: #195c2e;">Assalamu'alaikum, {{ $pengajuan->nama_lengkap }}</h2>
        <p>Alhamdulillah, berkas pengajuan bantuan Anda telah berhasil masuk ke sistem SIMPATIK BAZNAS Tanah Laut.</p>
        
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong>Nomor Resi</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">: {{ $pengajuan->nomor_pengajuan }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong>Tanggal Pengajuan</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">: {{ $pengajuan->created_at->format('d M Y') }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px;">Tim verifikator kami akan segera meninjau berkas Anda. Anda dapat memantau status pengajuan melalui Dashboard akun Anda.</p>
        
        <p style="color: #777; font-size: 12px; margin-top: 40px;">Wassalamu'alaikum Warahmatullahi Wabarakatuh,<br><strong>Tim BAZNAS Kabupaten Tanah Laut</strong></p>
    </div>
</body>
</html>