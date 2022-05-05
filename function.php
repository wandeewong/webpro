

<?php
    function alert($mes,$link)
    {
        echo "<script> alert('$mes'); </script>";
        header("Refresh:0; url=$link");
    }

    function SELECT($conn,$table)
    {
        $sql = "SELECT * FROM $table";
        $query = $conn->query($sql);
        return $query;
    }

    function SELECT_ID($conn,$table,$id)
    {
        $sql = "SELECT * FROM $table WHERE $id";
        $query = $conn->query($sql);
        return $query;
    }

    function SELECT_JOIN($conn,$table,$table2,$name)
    {
        $sql = "SELECT * FROM $table LEFT JOIN $table2 ON $table.$name = $table2.$name";
        $query = $conn->query($sql);
        return $query;
    }

    function INSERT($conn,$table,$name,$value)
    {
        $sql = "INSERT INTO $table ($name) VALUES ($value)";
        $query = $conn->query($sql);
        return $query;
    }

    function UPDATE($conn,$table,$value,$id)
    {
        $sql = "UPDATE $table SET $value WHERE $id";
        $query = $conn->query($sql);
        return $query;
    }

    function DELETE($conn,$table,$id)
    {
        $sql = "DELETE FROM $table WHERE $id";
        $query = $conn->query($sql);
        return $query;
    }
?>