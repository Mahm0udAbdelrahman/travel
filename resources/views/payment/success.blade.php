<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تم الدفع بنجاح</title>
    <style>
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2d3748;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px 60px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(99, 99, 99, 0.15);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            color: #38a169;
            /* أخضر */
            margin-bottom: 15px;
            font-size: 2.4rem;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }

        .session-id {
            background: #edf7ed;
            border: 1px solid #c6f6d5;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 600;
            color: #276749;
            display: inline-block;
            margin-bottom: 30px;
            word-break: break-all;
        }

        a {
            display: inline-block;
            background: #3182ce;
            /* أزرق */
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background: #2c5282;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>شكراً على الدفع!</h1>
        <p>تم تأكيد الدفع بنجاح.</p>
        <div class="session-id">رقم الجلسة: {{ $sessionId }}</div>
        <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>
    </div>
</body>

</html>
