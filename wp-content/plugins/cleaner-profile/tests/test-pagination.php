<?php
class CleanerProfilePaginationTest extends WP_UnitTestCase {

    public function setUp(): void {
        parent::setUp();
        // Include the pagination file if needed
        require_once dirname( __DIR__ ) . '/includes/pagination.php';
    }

    public function test_get_paginated_rows_returns_limited_rows() {
        $rows = range(1, 100);
        $page = 2;
        $per_page = 10;

        $result = get_paginated_rows($rows, $page, $per_page);

        $this->assertCount(10, $result);
        $this->assertEquals(range(11, 20), $result);
    }

    public function test_get_paginated_rows_returns_first_page() {
        $rows = range(1, 5);
        $page = 1;
        $per_page = 10;

        $result = get_paginated_rows($rows, $page, $per_page);

        $this->assertCount(5, $result);
        $this->assertEquals(range(1, 5), $result);
    }
}
