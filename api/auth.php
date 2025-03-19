    <?php
    session_start();

    header('Content-Type: application/json; charset=utf-8');
    include '../core/functions.php';
    include '../core/DBBuilder.php';

    global $conn;
    $db = new DBBuilder();
    $table = $db->table('admin');

    $method = $_SERVER['REQUEST_METHOD'];

    $key = isset($_GET['key']) ? mysqli_real_escape_string($conn, $_GET['key']) : null;
    $by = isset($_GET['by']) ? mysqli_real_escape_string($conn, $_GET['by']) : null;
    $type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : null;

    switch ($method) {
        case 'GET':
            if ($by === 'id' || $by === 'username') {
                $column = $by === 'id' ? 'id' : 'username';
                $data = $table->select('username, password, name, created_at as tanggal')
                    ->where($column, $key)
                    ->first();

                if ($data) {
                    echo json_encode($data, JSON_PRETTY_PRINT);
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Item not found']);
                }
                exit;
            }

            $result = $table->select('username, password, name, created_at as tanggal')->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case 'POST':
            $username = $_POST["username"] ?? '';
            $password = $_POST["password"] ?? '';
            $remember = $_POST['remember'] ?? null;
            $name = $_POST['name'] ?? null;

            if ($type == 'login') {
                $result = mysqli_query($conn, "SELECT * FROM `admin` WHERE username = '$username'");
                $result = $table->where('username', $username)->first();

                if ($result) {
                    if (password_verify($password, $result["password"])) {
                        $_SESSION["login"] = true;
                        $_SESSION['user'] = [
                            'username' => $result['username'],
                            'name' => $result['name'],
                        ];

                        if ($remember) {
                            setcookie('id', $result['id'], time() + 1440);
                            setcookie('key', hash('sha384', $result['username']), time() + 1440);
                        }
                        echo json_encode(1, JSON_PRETTY_PRINT);
                    } else {
                        http_response_code(401);
                        echo json_encode(['message' => 'Password salah.'], JSON_PRETTY_PRINT);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Username: <strong>' . $username . '</strong> tidak ditemukan.'], JSON_PRETTY_PRINT);
                }
            } else if ($type == 'registrasi') {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $timestamp = date('Y-m-d H:i:s');

                $result = $table->set(['username' => $username, 'password' => $password, 'name' => $name, 'created_at' => $timestamp])->insert();
                if (!$result) {
                    http_response_code(500);
                    echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                    die;
                }

                $response = [
                    'status' => true,
                    'message' => 'Admin berhasil ditambahkan.',
                    'data' => [
                        'username' => $username,
                    ]
                ];
                http_response_code(201);
                echo json_encode($response, JSON_PRETTY_PRINT);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Tipe post tidak ditemukan.']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            break;
    }
