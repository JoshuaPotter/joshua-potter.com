<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Freelancer Office
 * 
 * Web based project and invoicing management system available on codecanyon
 *
 * @package     Freelancer Office
 * @author      William Mandai
 * @copyright   Copyright (c) 2014 - 2016 Gitbench,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://codecanyon.net/item/freelancer-office/8870728
 * @link        https://gitbench.com
 */

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/Slim/Slim.php';

class Notes extends MX_Controller
{
    function __construct()
    {
        // Construct our parent class
        parent::__construct();
        User::logged_in();
        $this->load->model(array('App'));

    }

    function index(){
        $app = new Slim();
        $app->get('/notes', function () { $this->get_notes(); });
        $app->get('/notes/:id',function ($id) { $this->get_note($id); });
        $app->post('/notes', function () { $this->add_note(); });
        $app->put('/notes/:id', function ($id) { $this->update_note($id); });
        $app->delete('/notes/:id',function ($id) { $this->delete_note($id); });

        $app->run();
    }

    function get_notes() {
        $owner = User::get_id();
        $sql = "SELECT * FROM fx_notes WHERE owner='$owner'";
        try {
            $db = $this->getConnection();
            $stmt = $db->query($sql);
            $notes = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            // echo '{"note": ' . json_encode($notes) . '}';
            echo json_encode($notes);
            exit;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function get_note($id) {
        $sql = "SELECT * FROM fx_notes WHERE id=:id";
        try {
            $db = $this->getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $note = $stmt->fetchObject();
            $db = null;
            echo json_encode($note); exit;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function add_note() {
        $user = User::get_id();
        $request = Slim::getInstance()->request();
        $note = json_decode($request->getBody());
        $sql = "INSERT INTO fx_notes (name, description, date, owner) VALUES (:name, :description, :date, :owner)";
        try {
            $db = $this->getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("name", $note->name);
            $stmt->bindParam("description", $note->description);
            $stmt->bindParam("date", $note->date);
            $stmt->bindParam("owner", $user);
            $stmt->execute();
            $note->id = $db->lastInsertId();
            $db = null;
            echo json_encode($note); exit;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function update_note($id) {
        $user = User::get_id();
        $request = Slim::getInstance()->request();
        $body = $request->getBody();
        $note = json_decode($body);
        $sql = "UPDATE fx_notes SET name=:name, description=:description, date=:date,owner=:owner WHERE id=:id";
        try {
            $db = $this->getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("name", $note->name);
            $stmt->bindParam("description", $note->description);
            $stmt->bindParam("date", $note->date);
            $stmt->bindParam("owner", $user);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            echo json_encode($note); exit;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function delete_note($id) {
        $sql = "DELETE FROM fx_notes WHERE id=:id";
        try {
            $db = $this->getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function getConnection() {
        $dbhost = $this->db->hostname;
        $dbuser = $this->db->username;
        $dbpass = $this->db->password;
        $dbname = $this->db->database;
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

}
// End of notes API