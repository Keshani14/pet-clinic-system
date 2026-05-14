<?php

/**
 * DbValidator — ensures the database is correctly set up.
 */
class DbValidator {

    private static $requiredTables = [
        'users', 'pets', 'appointments', 'nurse_notes', 
        'medical_records', 'vaccine_templates', 'vaccination_schedule', 
        'vaccinations', 'pet_vaccination_history', 'status_logs'
    ];

    /**
     * Verify that all required tables exist.
     * Throws an Exception or dies with a clear message if missing.
     */
    public static function validate(): void {
        try {
            $db = new Database();
            $existingTables = [];
            
            $result = $db->conn->query("SHOW TABLES");
            if (!$result) {
                throw new Exception("Could not query database tables. Ensure database 'pet_clinic' exists.");
            }

            while ($row = $result->fetch_array()) {
                $existingTables[] = $row[0];
            }

            $missing = array_diff(self::$requiredTables, $existingTables);

            if (!empty($missing)) {
                $missingList = implode(", ", $missing);
                self::renderError("Database Schema Incomplete", "The following required tables are missing: <strong>$missingList</strong>. Please import <code>config/database.sql</code>.");
            }
        } catch (Exception $e) {
            self::renderError("Database Error", $e->getMessage());
        }
    }

    /** Renders a clean error page for DB issues */
    private static function renderError(string $title, string $message): void {
        http_response_code(500);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?php echo $title; ?> — System Error</title>
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #fff5f8; color: #333; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
                .error-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 500px; text-align: center; border: 2px solid #ffe4ef; }
                h1 { color: #db2777; margin-top: 0; }
                p { line-height: 1.6; color: #666; }
                code { background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="error-card">
                <h1>⚠️ <?php echo $title; ?></h1>
                <p><?php echo $message; ?></p>
                <hr style="border: 0; border-top: 1px solid #ffe4ef; margin: 20px 0;">
                <small style="color: #999;">Check your <code>core/database.php</code> configuration.</small>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}
