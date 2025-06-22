<?php
    function get_paginated_rows(array $rows, int $page, int $per_page): array {
        $offset = ($page - 1) * $per_page;
        return array_slice($rows, $offset, $per_page);
    }