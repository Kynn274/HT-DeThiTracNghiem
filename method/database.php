<?php
    class Database
    {
        public $CONFIG_servername = "localhost";
        public $CONFIG_username = "root";
        public $CONFIG_password = "";
        public $CONFIG_dbname = "HT-DeThiTracNghiem";

        public $conn;

        public $query = null;

        public function __construct()
        {
            $this->conn = new mysqli($this->CONFIG_servername, $this->CONFIG_username, $this->CONFIG_password, $this->CONFIG_dbname);

            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        public function set_query($sql)
        {
            $this->query = $sql;
        }

        public function excute_query()
        {
            $result = $this->conn->query($this->query);
            return $result;
        }

        public function close()
        {
            $this->conn->close();
        }
    }
?>
