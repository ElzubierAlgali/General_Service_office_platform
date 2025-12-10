<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنبيه تسجيل دخول</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: black;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-box i {
            color: #856404;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table tr {
            border-bottom: 1px solid #eee;
        }
        .info-table td {
            padding: 12px 0;
        }
        .info-table td:first-child {
            font-weight: bold;
            color: #666;
            width: 40%;
        }
        .info-table td:last-child {
            color: #333;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .warning-text {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 تنبيه أمني</h1>
            <p>تسجيل دخول جديد إلى نظام صِـدقا</p>
        </div>

        <div class="content">
            <div class="alert-box">
                <strong>⚠️ تم تسجيل دخول جديد</strong>
                <p style="margin: 10px 0 0;">تم تسجيل الدخول إلى حسابك من جهاز أو موقع جديد.</p>
            </div>

            <p>مرحباً،</p>
            <p>نود إعلامك بأنه تم تسجيل دخول جديد إلى نظام إدارة شركة صِـدقا بالتفاصيل التالية:</p>

            <table class="info-table">
                <tr>
                    <td>👤 المستخدم</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td>📧 البريد الإلكتروني</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>🕐 وقت الدخول</td>
                    <td>{{ $loginTime }}</td>
                </tr>
                <tr>
                    <td>🌐 عنوان IP</td>
                    <td>{{ $ipAddress }}</td>
                </tr>
                <tr>
                    <td>💻 المتصفح / الجهاز</td>
                    <td style="font-size: 11px;">{{ Str::limit($userAgent, 80) }}</td>
                </tr>
            </table>

            <p><strong>إذا كنت أنت من قام بتسجيل الدخول:</strong> يمكنك تجاهل هذه الرسالة.</p>

            <p class="warning-text">إذا لم تكن أنت من قام بتسجيل الدخول، يرجى:</p>
            <ol>
                <li>تغيير كلمة المرور الخاصة بك فوراً</li>
                <li>التواصل مع مسؤول النظام</li>
                <li>مراجعة نشاط حسابك</li>
            </ol>
        </div>

        <div class="footer">
            <p>هذه رسالة آلية من نظام إدارة شركة صِـدقا</p>
            <p>للدعم الفني: <a href="mailto:support@sidqa.sa">support@sidqa.sa</a></p>
            <p>© {{ date('Y') }} شركة صِـدقا - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>

