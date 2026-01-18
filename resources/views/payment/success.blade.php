<!DOCTYPE html>
<html>
<head>
    <title>تم الدفع بنجاح</title>
</head>
<body>
    <h1>شكراً على الدفع!</h1>
    <p>تم تأكيد الدفع بنجاح.</p>
    <p>رقم الجلسة: {{ $sessionId }}</p>
    <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>
</body>
</html>
