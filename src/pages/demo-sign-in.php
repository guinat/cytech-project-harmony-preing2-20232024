<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>

    <link rel="icon" href="/src/favicon.ico" type="image/x-icon">
    <title>Demo Sign In</title>
</head>
<body class="bg-gradient-to-r from-[#F28383] from-10% via-[#9D6CD2] via-30% to-[#481EDC] to-90% flex items-center justify-center h-screen">
    <div class="maw-w-[960px] bg-[#00000050] grid grid-cols-2 items-center gap-20 p-5 rounded-2xl">
        <div class="relative">
            <img src="/assets/components/hero/signup-background.svg">
            <img src="/assets/components/hero/teamwork.svg" class="absolute top-36">
        </div>

        <div class="max-w-80 grid gap-5">
            <h1 class="text-5xl text-white font-bold mb-[30px]">Login</h1>
            <form action="" class="space-y-6 text-white">
                <div>
                    <input type="email" placeholder="Email Address" class="w-80 bg-[#FFFFFF30] py-2 px-3 rounded-full focus:bg-[#00000050] focus: outline-none focus:ring focus:ring-[#2FB8FF] focus:drop-shadow-lg">
                </div>
                <div>
                    <input type="text" placeholder="Password" class="w-80 bg-[#FFFFFF30] py-2 px-3 rounded-full focus:bg-[#00000050] focus: outline-none focus:ring focus:ring-[#2FB8FF] focus:drop-shadow-lg">
                </div>
                <button class="bg-gradient-to-r from-sky-400 to-cyan-200 w-80 font-semibold rounded-full py-2">Sign in</button>
            </form>
            <div class="text-[#ffffffa6] border-t border-[#ffffff3b] pt-4 space-y-4 text-sm">
                <p>Don't have an account ? <a href="" class="text-[#2FB8FF]">Sign up</a></p>
                <p>Forgotten password ? <a href="" class="text-[#2FB8FF]">Reset password</a></p>
                <p>Don't have an account ? <a href="" class="text-[#2FB8FF]">Set password</a></p>
            </div>
        </div>
    </div>
</body>
</html>