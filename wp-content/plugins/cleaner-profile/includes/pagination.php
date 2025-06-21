<?php
    function cleaner_profile_paginate_rows( array $rows, int $page = 1, int $rows_per_page = 10 ): array {
        $offset = ($page - 1) * $rows_per_page;
        return array_slice($rows, $offset, $rows_per_page);
    }
?>