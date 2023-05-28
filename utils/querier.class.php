<?php

class querier
{
    public static function query($q, ...$params)
	{
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }
        // TODO: sanitaize functions for the params
        return $conn->query($q);

	}
} 