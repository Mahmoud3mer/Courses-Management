<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="overflow-x:hidden; overflow-y:auto">
    <div class="row">
        <div class="col-md-6 col-12" style="height: 100vh">
            <img src="{{ asset('learning-education-ideas-insight-intelligence-study-concept.jpg') }}" class="w-100 h-100"
                alt="">
        </div>

        <div class="col-md-6 col-12"
            style="display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">

            <h1>تسجيل الدخول</h1>

            @if (session('error'))
                <div class="alert alert-danger" style="margin-top: 15px;">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class='w-100' style='padding-inline:15px;'>
                @csrf
                <div class="mb-3">
                    {{-- <label>البريد الإلكتروني</label> --}}
                    <label>{{ __('auth.label.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>{{ __('auth.label.password') }}</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
                    <a href="{{ route('register') }}" class="btn btn-link">إنشاء حساب جديد</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
