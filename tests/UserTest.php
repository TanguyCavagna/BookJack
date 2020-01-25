<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../App/Controller/UserController.php';

class UserTest extends TestCase {
    
    protected static $userController;

    //=========================================
    // Setup
    //=========================================
    /**
     * Setup all shared fixtures
     */
    public static function setUpBeforeClass(): void {
        self::$userController = new UserController();
    }

    /**
     * Unset all shared fixtures
     */
    public static function tearDownAfterClass(): void {
        self::$userController = null;
    }

    //=========================================
    // Tests
    //=========================================
    /**
     * @dataProvider newUserProvider
     */
    public function testRegisterNewUser(string $email, string $nickname, string $pass, bool $expected): void {
        // Assignation

        // Actions
        $registerState = self::$userController->RegisterNewUser($email, $nickname, $pass);

        // Asserts
        $this->assertEquals($expected, $registerState);
    }

    /**
     * @dataProvider loginWithEmailProvider
     */
    public function testLoginWithEmail(string $email, string $pass): void {
        // Assignation
        
        // Actions
        $logged = self::$userController->Login(['userEmail' => $email, 'userPwd' => $pass]);

        // Asserts
        $this->assertNotNull($logged);
    }

    /**
     * @dataProvider loginWithNicknameProvider
     */
    public function testLoginWithNickname(string $nickname, string $pass): void {
        // Assignation
        
        // Actions
        $logged = self::$userController->Login(['userNickname' => $nickname, 'userPwd' => $pass]);

        // Asserts
        $this->assertNotNull($logged);
    }

    /**
     * @dataProvider loginWithEmailProvider
     */
    public function testUpdateNicknameById(string $email, string $pass): void {
        // Assignation
        $logged = self::$userController->Login(['userEmail' => $email, 'userPwd' => $pass]);

        // Actions
        $updateState = self::$userController->UpdateNicknameById($logged->id, 'test 2');

        // Asserts
        $this->assertEquals(true, $updateState);
    }

    /**
     * @dataProvider loginWithEmailProvider
     */
    public function testUpdateEmailById(string $email, string $pass): void {
        // Assignation
        $logged = self::$userController->Login(['userEmail' => $email, 'userPwd' => $pass]);

        // Actions
        $updateState = self::$userController->UpdateEmailById($logged->id, 'test2@test.com');

        // Asserts
        $this->assertEquals(true, $updateState);
    }

    /**
     * @dataProvider loginWithEmailAfterEmailChangedProvider
     */
    public function testUpdatePasswordById(string $email, string $pass): void {
        // Assignation
        $logged = self::$userController->Login(['userEmail' => $email, 'userPwd' => $pass]);

        // Actions
        $updateState = self::$userController->UpdatePasswordById($logged->id, 'TestTest2');

        // Asserts
        $this->assertEquals(true, $updateState);
    }

    /**
     * @dataProvider loginWithEmailAfterEmailAndPassChangedProvider
     */
    public function testUpdateProfilPictureById(string $email, string $pass): void {
        // Assignation
        $logged = self::$userController->Login(['userEmail' => $email, 'userPwd' => $pass]);

        // Actions
        $updateState = self::$userController->UpdatePasswordById($logged->id, 'TestTest2');

        // Asserts
        $this->assertEquals(true, $updateState);
    }

    /**
     * @dataProvider loginWithEmailAfterEmailAndPassChangedProvider
     */
    public function testDeleteById(string $email, string $pass): void {
        // Assignation
        $logged = self::$userController->Login(['userEmail' => $email, 'userPwd' => $pass]);

        // Actions
        $deleteState = self::$userController->DeleteById($logged->id);

        // Asserts
        $this->assertEquals(true, $deleteState);
    }

    //=========================================
    // Providers
    //=========================================
    /**
     * Data provider for the register function
     */
    public function newUserProvider(): array {
        return [
            ["test@test.com", "test", "TestTest", true],
        ];
    }

    /**
     * Data provider for the login with email
     */
    public function loginWithEmailProvider(): array {
        return [
            ['test@test.com', 'TestTest']
        ];
    }

    /**
     * Data provider for the login with email
     */
    public function loginWithNicknameProvider(): array {
        return [
            ['test', 'TestTest']
        ];
    }

    /**
     * Data provider after having change the email
     */
    public function loginWithEmailAfterEmailChangedProvider(): array {
        return [
            ['test2@test.com', 'TestTest']
        ];
    }

    /**
     * Data provider after having change the email and the password
     */
    public function loginWithEmailAfterEmailAndPassChangedProvider(): array {
        return [
            ['test2@test.com', 'TestTest2']
        ];
    }
}