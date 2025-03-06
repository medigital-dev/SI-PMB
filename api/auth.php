    <?php
    session_start();

    header('Content-Type: application/json; charset=utf-8');
    include '../core/functions.php';
    global $conn;

    $method = $_SERVER['REQUEST_METHOD'];

    $key = isset($_GET['key']) ? mysqli_real_escape_string($conn, $_GET['key']) : null;
    $by = isset($_GET['by']) ? mysqli_real_escape_string($conn, $_GET['by']) : null;
    $type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : null;

    switch ($method) {
        case 'GET':
            if ($by === 'id' || $by === 'username') {
                $column = $by === 'id' ? 'id' : 'username';
                $sql = "SELECT username, `password`, `name`, created_at AS tanggal FROM `admin` WHERE $column = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $key);
                mysqli_stmt_execute($stmt);
                $query = mysqli_stmt_get_result($stmt);
                $data = mysqli_fetch_assoc($query);

                if ($data) {
                    echo json_encode($data, JSON_PRETTY_PRINT);
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Item not found']);
                }
                exit;
            }

            $sql = "SELECT username, `password`, `name`, created_at AS tanggal FROM `admin`";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);

            break;

        case 'POST':
            if ($type == 'login') {
                $username = $_POST["username"] ?? '';
                $password = $_POST["password"] ?? '';
                $remember = $_POST['remember'] ?? null;

                $result = mysqli_query($conn, "SELECT * FROM `admin` WHERE username = '$username'");

                if (mysqli_num_rows($result) === 1) {

                    $row = mysqli_fetch_assoc($result);
                    if (password_verify($password, $row["password"])) {

                        $_SESSION["login"] = true;
                        $_SESSION['user'] = [
                            'username' => $row['username'],
                            'name' => $row['name'],
                        ];

                        if ($remember) {
                            setcookie('id', $row['id'], time() + 1440);
                            setcookie('key', hash('sha384', $row['username']), time() + 1440);
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
                $username = $_POST['username'] ?? null;
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ?? null;
                $name = $_POST['name'] ?? null;
                $timestamp = date('Y-m-d H:i:s');

                $sql = "INSERT INTO `admin` (username, `password`, `name`, created_at) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $name, $timestamp);
                $result = mysqli_stmt_execute($stmt);

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
