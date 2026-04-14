<?php
session_start();

const DEMO_USERNAME = 'admin';
const DEMO_PASSWORD = 'password123';

$error = '';
$loggedIn = isset($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === DEMO_USERNAME && $password === DEMO_PASSWORD) {
        $_SESSION['user'] = $username;
        $loggedIn = true;
    } else {
        $error = '用户名或密码错误，请重试。';
        $loggedIn = false;
    }
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登录页面</title>
  <style>
    :root {
      --primary: #2563eb;
      --bg: #f3f4f6;
      --card: #ffffff;
      --text: #1f2937;
      --danger: #dc2626;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background: var(--bg);
      display: flex;
      justify-content: center;
      align-items: center;
      color: var(--text);
    }

    .card {
      width: min(420px, 92%);
      background: var(--card);
      border-radius: 12px;
      padding: 28px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h1 {
      margin: 0 0 18px;
      font-size: 1.6rem;
      color: var(--primary);
    }

    .hint {
      margin: 0 0 16px;
      font-size: 0.92rem;
      color: #4b5563;
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 8px;
      padding: 10px 12px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
    }

    input {
      width: 100%;
      box-sizing: border-box;
      padding: 10px 12px;
      margin-bottom: 14px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 1rem;
    }

    button,
    .logout {
      width: 100%;
      border: 0;
      border-radius: 8px;
      padding: 11px 14px;
      font-size: 1rem;
      text-decoration: none;
      text-align: center;
      display: inline-block;
      cursor: pointer;
    }

    button {
      background: var(--primary);
      color: #fff;
      font-weight: 600;
    }

    .error {
      color: var(--danger);
      margin-bottom: 12px;
      font-size: 0.95rem;
    }

    .success {
      margin: 10px 0 16px;
      font-size: 1rem;
    }

    .logout {
      background: #111827;
      color: #fff;
    }
  </style>
</head>
<body>
  <main class="card">
    <h1>用户登录</h1>

    <?php if ($loggedIn): ?>
      <p class="success">登录成功，欢迎你：<strong><?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?></strong></p>
      <a class="logout" href="?logout=1">退出登录</a>
    <?php else: ?>
      <p class="hint">演示账号：admin / password123</p>
      <?php if ($error !== ''): ?>
        <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <form method="post" action="">
        <label for="username">用户名</label>
        <input id="username" name="username" type="text" required autocomplete="username">

        <label for="password">密码</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">

        <button type="submit">登录</button>
      </form>
    <?php endif; ?>
  </main>
</body>
</html>
