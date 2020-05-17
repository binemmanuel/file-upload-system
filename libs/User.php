 <?php
/**
 * User class.
 */
class User
{
    /* Properties */
    /**
     * @var int User ID.
     */
    public $id;

    /**
     * @var string User email.
     */
    public $email;

    /**
     * @var string User's full name.
     */
    public $full_name;

    /**
     * @var string User's password.
     */
    public $password;

    /**
     * @var string User's password reset token.
     */
    public $role;

    /**
     * @var string User's account status.
     */
    public $status;

    /**
     * @var string User's profile picture.
     */
    public $profile_pic;

    /**
     * @var string Account registeration date.
     */
    public $reg_date;

    public function __construct(
        int $id = null,
        string $email = null,
        string $full_name = null,
        string $password = null,
        string $role = null,
        string $status = null,
        string $profile_pic = null,
        string $reg_date = null)
    {
        /* Check if data are provided then store them */
        if (!empty($id)) {
            $this->id = (int) $id;
        }

        if (!empty($email)) {
            $this->email = (string) $email;
        }

        if (!empty($full_name)) {
            $this->full_name = (string) $full_name;
        }

        if (!empty($password)) {
            $this->password = (string) $password;
        }

        if (!empty($role)) {
            $this->role = (string) $role;
        }

        if (!empty($status)) {
            $this->status = (string) $status;
        }

        if (!empty($profile_pic)) {
            $this->profile_pic = (string) $profile_pic;
        }

        if (!empty($reg_date)) {
            $this->reg_date = (string) $reg_date;
        }
    }

    /**
     * Create daily report.
     * 
     * @return bool false | true if the report was created successfully.
     */
    public function create_account(): bool
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an SQL statement.
        $stmt = $conn->prepare('INSERT INTO users(
            email,
            full_name,
            password,
            role
            ) values(?, ?, ?, ?)'
        );

        // Bind parameters.
        $stmt->bind_param('ssss',
            $this->email,
            $this->full_name,
            $this->password,
            $this->role
        );

        // Execute query.
        if ($stmt->execute()) {
            $_SESSION['id'] = $stmt->insert_id;

            return true;
        }

        // Close connection.
        $conn->close();

        // Close statement.
        $stmt->close();

        return false;
    }

    /**
     * Check if a user already exist.
     * 
     * @param string The email.
     * @return bool false or true if the user exsit.
     */
    public static function user_exist(string $email): bool
    {
        if (empty($email)) {
            // Throw an error message.
            throw new Exception('Error trying to verify a User Object that doesn\'t has it\'s email set', 1);

        } else {
            // Clean user data.
            $email = (string) clean_data($email);

        }

        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an SQL statement.
        $stmt = $conn->prepare('SELECT email FROM users WHERE email = ? LIMIT 1');

        // Bind parameter.
        $stmt->bind_param('s', $email);

        // Execute the query.
        $stmt->execute();

        // Store return values.
        $stmt->store_result();

        // Store the number of rows.
        $num_rows = $stmt->num_rows();

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        //  Return the number of rows.
        return (bool) $num_rows;
    }

    /**
     * Verify user credentials.
     * 
     * @return bool false or true if the user exsit.
     */
    public function verify_user(): bool
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an SQL statement.
        $stmt = $conn->prepare('SELECT id, email, full_name, password, role, status FROM users WHERE email = ?');

        // Bind parameter.
        $stmt->bind_param('s', $this->email);

        // Execute the query.
        $stmt->execute();

        // Store return values.
        $stmt->bind_result($id, $email, $full_name, $password, $role, $status);
        
        // Fetch user data.
        $stmt->fetch();

        // Verify password.
        if (password_verify($this->password, $password) && !empty($status)) {
            // // Generate a new session ID.
            session_regenerate_id(true);

            // Store session.
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role'] = $role;
            $_SESSION['status'] = $status;

            return true;
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        return false;
    }

    /**
     * Get all users.
     * 
     * @return 
     */
    public function get_users(): array
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Initialize an empty array.
        $data = [];

        // Prepare an sql statement.
        $stmt = $conn->prepare(
            'SELECT
        id,
        email,
        full_name,
        role,
        status,
        profile_pic,
        date FROM users
        WHERE NOT role = "admin" AND NOT role = "super admin"
        ORDER BY full_name ASC'
        );

        // Execute query.
        if ($stmt->execute()) {
            // Store result.
            $stmt->store_result();

            $stmt->bind_result(
                $id,
                $email,
                $full_name,
                $role,
                $status,
                $profile_pic,
                $date
            );

            // Loop through user data.
            while ($stmt->fetch()) {
                // Instantiate a User Object.
                $user = new User;

                // Set user data.
                $user->id = $id;
                $user->email = $email;
                $user->full_name = $full_name;
                $user->role = $role;
                $user->status = $status;
                $user->profile_pic = $profile_pic;
                $user->date = $date;

                // Create an array of object.
                array_push($data, $user);
            }
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        // Return user data.
        return $data;
    }

    /**
     * Get all students.
     * 
     * @return array A list of all students.
     */
    public function get_students(): array
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Initialize an empty array.
        $data = [];

        // Prepare an sql statement.
        $stmt = $conn->prepare('
            SELECT
            users.id,
            users.email,
            users.full_name,
            users.role,
            users.status,
            time_table.teachers_id,
            time_table.course_id,
            users.date
            FROM users INNER JOIN time_table
            ON users.id = time_table.student_id
            WHERE role = "student"
            ORDER BY id DESC'
        );

        // Execute query.
        if ($stmt->execute()) {
            // Store result.
            $stmt->store_result();

            $stmt->bind_result(
                $id,
                $email,
                $full_name,
                $role,
                $status,
                $teacher,
                $course,
                $date
            );

            // Loop through user data.
            while ($stmt->fetch()) {
                // Instantiate a User Object.
                $user = new User;
                $user->id = $id;
                $user->email = $email;
                $user->full_name = $full_name;
                $user->role = $role;
                $user->status = $status;
                $user->teacher = $teacher;
                $user->course = $course;
                $user->date = $date;

                // Create an array of object.
                array_push($data, $user); 
            }
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        // Return user data.
        return $data;
    }

    /**
     * Get a user by ID.
     * 
     * @return object A user Object.
     */
    public function get_user(): object
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Instantiate a User Object.
        $user = new User;

        // Prepare an sql statement.
        $stmt = $conn->prepare('SELECT id, email, full_name, role, status, profile_pic, date FROM users WHERE id = ?');

        // Bind param.
        $stmt->bind_param('i', $this->id);

        // Execute query.
        if ($stmt->execute()) {
            // Store result.
            $stmt->store_result();

            $stmt->bind_result($id, $email, $full_name, $role, $status, $profile_pic, $date);

            // Fetch user data.
            if ($stmt->fetch()) {
                // Set user data.
                $user->id = $id;
                $user->email = $email;
                $user->full_name = $full_name;
                $user->role = $role;
                $user->status = $status;
                $user->profile_pic = $profile_pic;
                $user->date = $date;
            }
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        // Return user data.
        return $user;
    }

    /**
     * Deletes a user account.
     */
    public static function delete(int $id): bool
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an SQL statement.
        $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');

        // Bind parameter.
        $stmt->bind_param('i', $id);

        // Execute query.
        if ($stmt->execute()) {
            return true;
        }

        // Close connection.
        $conn->close();

        // Close statement.
        $stmt->close();

        return false;
    }

    public function get_user_id(): int
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an sql statement.
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');

        // Bind parameters.
        $stmt->bind_param('s', $this->email);

        // Execute query.
        if ($stmt->execute()) {
            // Store result.
            $stmt->store_result();

            $stmt->bind_result($id);

            // Fetch user data.
            $stmt->fetch();
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        // Return user data.
        return (int) $id;
    }

    public static function get_user_fullname_by_id(int $id): string
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Sanitize data.
        $id = (int) clean_data($id);
        // Prepare an sql statement.

        $stmt = $conn->prepare('SELECT full_name FROM users WHERE id = ?');

        // Bind parameters.
        $stmt->bind_param('s', $id);

        // Execute query.
        if ($stmt->execute()) {
            // Store result.
            $stmt->store_result();

            $stmt->bind_result($full_name);

            // Fetch user data.
            $stmt->fetch();
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        // Return user data.
        return (string) $full_name;
    }

    public static function get_user_login_atmt(int $user_id): int
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Sanitize data.
        $user_id = (int) clean_data($user_id);

        // Prepare an sql statement.
        $stmt = $conn->prepare('SELECT attempt FROM login_attempts WHERE user_id = ?');
        // Bind parameters.

        $stmt->bind_param('i', $user_id);

        // Execute query.
        if ($stmt->execute()) {
            // Store result.
            $stmt->store_result();

            $stmt->bind_result($attempt);

            // Fetch user data.
            $stmt->fetch();
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        // Return user data.
        return (int) $attempt;
    }

    public static function check_attempt(int $user_id): bool
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an sql statement.
        $stmt = $conn->prepare('SELECT attempt FROM login_attempts WHERE user_id = ?');

        // Bind parameter.
        $stmt->bind_param('i', $user_id);

        // Execute query.
        $stmt->execute();

        // Store result.
        $stmt->store_result();

        // Check if the user has made a prev attempt.
        if ($stmt->num_rows()) {
            return true;
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();
        return false;
    }

    public static function delete_attempt(int $user_id): bool
    {
        // Include our connection file.
        require 'libs/conn.php';

        // Prepare an sql statement.
        $stmt = $conn->prepare('DELETE FROM login_attempts WHERE user_id = ?');

        // Bind parameter.
        $stmt->bind_param('i', $user_id);

        // Execute query.
        if ($stmt->execute()){
            return true;
        }

        // Close connection and statement.
        $stmt->close();
        $conn->close();

        return false;

    }

    /**
     * Keep track of login attempts.
     * 
     * @return bool false or true if login attempt was stored successfully.
     */
    public static function store_login_atmt(int $user_id, int $atmt): bool
    {
        // Include our connection file.
        require 'libs/conn.php';

        $user_id = (int) clean_data($user_id);
        $atmt = (int) clean_data($atmt);

        // Prepare an SQL statement.
        $stmt = $conn->prepare('INSERT INTO login_attempts(user_id, attempt) values(?, ?)');

        // Bind parameters.
        $stmt->bind_param('ii', $user_id, $atmt);

        // Execute query.
        if ($stmt->execute()) {
            return true;
        }

        // Close connection.
        $conn->close();

        // Close statement.



        $stmt->close();







        return false;



    }







    /**



     * Update user's login attempt.



     * 



     * @return bool false or true if login attempt was stored successfully.



     */



    public static function update_attempt(int $user_id, int $atmt): bool



    {



        // Include our connection file.



        require 'libs/conn.php';







        $user_id = (int) clean_data($user_id);



        $atmt = (int) clean_data($atmt);







        // Prepare an SQL statement.



        $stmt = $conn->prepare('UPDATE login_attempts SET attempt = ? WHERE user_id = ?');







        // Bind parameters.



        $stmt->bind_param('ii', $atmt, $user_id);







        // Execute query.



        if ($stmt->execute()) {



            return true;



        }







        // Close connection.



        $conn->close();



        



        // Close statement.



        $stmt->close();







        return false;



    }

    /**
     * Change user's account status.
     * 
     * @return bool false or true if account status was changed successfully.
     */
    public static function change_status(int $status, $user_id): bool
    {
        // Include our connection file.

        require 'libs/conn.php';

        $status = (int) clean_data($status);

        $user_id = (int) clean_data($user_id);

        // Prepare an SQL statement.
        $stmt = $conn->prepare('UPDATE users SET status = ? WHERE id = ?');

        // Bind parameters.
        $stmt->bind_param('ii', $status, $user_id);

        // Execute query.
        if ($stmt->execute()) {
            return true;
        }

        // Close connection.
        $conn->close();

        // Close statement.
        $stmt->close();

        return false;
    }
        /**



         * Change user's account status.



         * 



         * @return bool false or true if account status was changed successfully.



         */



        public static function set_profile_pic(string $profile_pic, $user_id): bool



        {



            // Include our connection file.



            require 'libs/conn.php';







            $profile_pic = (string) urldecode($profile_pic);

            echo $user_id = (int) clean_data($user_id);







            // Prepare an SQL statement.



            $stmt = $conn->prepare('UPDATE users SET profile_pic = ? WHERE id = ?');







            // Bind parameters.



            $stmt->bind_param('si', $profile_pic, $user_id);







            // Execute query.



            if ($stmt->execute()) {



                return true;

            }







            // Close connection.



            $conn->close();







            // Close statement.



            $stmt->close();







            return false;

        }







    /**



     * Change user's email address.



     * 



     * @return bool false or true if email was changed successfully.



     */



    public static function change_email(string $email, $user_id): bool



    {



        // Include our connection file.



        require 'libs/conn.php';







        $email = (string) clean_data($email);



        $user_id = (int) clean_data($user_id);







        // Prepare an SQL statement.



        $stmt = $conn->prepare('UPDATE users SET email = ? WHERE id = ?');







        // Bind parameters.



        $stmt->bind_param('si', $email, $user_id);







        // Execute query.



        if ($stmt->execute()) {



            return true;



        }







        // Close connection.



        $conn->close();







        // Close statement.



        $stmt->close();







        return false;



    }







    /**



     * Change user's password.



     * 



     * @return bool false or true if password was changed successfully.



     */



    public static function change_password(string $password, $user_id): bool



    {



        // Include our connection file.



        require 'libs/conn.php';







        $password = (string) clean_data($password);



        $user_id = (int) clean_data($user_id);







        // Prepare an SQL statement.



        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');







        // Bind parameters.



        $stmt->bind_param('si', $password, $user_id);







        // Execute query.



        if ($stmt->execute()) {



            return true;



        }







        // Close connection.



        $conn->close();



        



        // Close statement.



        $stmt->close();







        return false;



    }







    /**



     * Change user's Role.



     * 



     * @return bool false or true if user's role was changed successfully.



     */



    public static function change_role(string $role, $user_id): bool



    {



        // Include our connection file.



        require 'libs/conn.php';







        $role = (string) clean_data($role);



        $user_id = (int) clean_data($user_id);







        // Prepare an SQL statement.



        $stmt = $conn->prepare('UPDATE users SET role = ? WHERE id = ?');







        // Bind parameters.



        $stmt->bind_param('si', $role, $user_id);







        // Execute query.



        if ($stmt->execute()) {



            return true;



        }







        // Close connection.



        $conn->close();



        



        // Close statement.



        $stmt->close();







        return false;



    }



}