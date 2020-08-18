<?php
/**
 * Boutique engine room
 *
 * @package boutique
 */

/**
 * Set the theme version number as a global variable
 */
$theme				= wp_get_theme( 'boutique' );
$boutique_version	= $theme['Version'];

$theme				= wp_get_theme( 'storefront' );
$storefront_version	= $theme['Version'];

/**
 * Load the individual classes required by this theme
 */
require_once( 'inc/class-boutique.php' );
require_once( 'inc/class-boutique-customizer.php' );
require_once( 'inc/class-boutique-template.php' );
require_once( 'inc/class-boutique-integrations.php' );

/******************************************************************************/

function menuSeletivo(){
    $idUser = get_current_user_id();
    
    if($idUser != 1){
        remove_menu_page( 'woocommerce' );
        remove_menu_page( 'index.php' );                  //Dashboard
        remove_menu_page( 'jetpack' );                    //Jetpack* 
        remove_menu_page( 'edit.php' );                   //Posts
        remove_menu_page( 'upload.php' );                 //Media
        remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        remove_menu_page( 'themes.php' );                 //Appearance
        remove_menu_page( 'plugins.php' );                //Plugins
        remove_menu_page( 'users.php' );                  //Users
        remove_menu_page( 'tools.php' );                  //Tools
        remove_menu_page( 'options-general.php' );        //Settings
    }
}

add_action('admin_menu', 'menuSeletivo');

function menuWhatsApp (){
    add_menu_page(  'Mudar Número Whats App',//título da página
                    'Numero WhatsApp',//título do Menu
                    'manage_options',//Tipo de acesso
                    'menu-whats-app',//slug
                    'menuMain',//função de callback
                    'dashicons-format-chat',//icone
                    4);//posição no Menu
    
}

add_action('admin_menu', 'menuWhatsApp');


function menuMain(){
    echo 
    '<div class="wrap"><h2>Menu Whats App</h2>
    
    
    <form action ="" method="POST">
        <label for="fname">Editar o número do WhatsApp: </label><br><br>
        Telefone <input type="tel" id="phone" name="phone" placeholder="5531952369632" maxlength="13"><br>
        <input type="submit" value="Salvar" name="submit_btn">
    </form> 
';

    if(isset($_REQUEST['submit_btn'])){

        if($_POST["phone"] != null) {
            alteraNumWhatsApp($_POST["phone"]);
        }else{
            echo "Atualização não realizada, o campo não pode ser vazio.";
        }
    }
    
    echo '<h3>Número WhatsApp Cadastrado: ';
    echo selectNumWhatsApp(). "</h3></div>";
    
//echo get_current_user_id();*/
}


function alteraNumWhatsApp($numNovo){
    $servername = "meuapp.de";
    $username = "meuapp_ind0";  //ALTERAR O NOME PARA O NOME DO USUÁRIO
    $password = "#pontti@#";    //ALTERAR A SENHA PARA A SENHA DO BANCO
    $dbname = "meuapp_ind0";    //ALTERAR O NOME PARA O NOME DO BANCO
    $userId = '1';
    
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$sql = "SELECT user_tel FROM cl_users";
    $sql = "UPDATE pnt_users SET user_tel='".$numNovo." ' WHERE ID=". $userId;
    $result = $conn->query($sql);
    
    if ($conn->query($sql) === TRUE) {
        echo "Número Salvo com sucesso!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}

function selectNumWhatsApp(){
    $servername = "meuapp.de";
    $username = "meuapp_ind0";
    $password = "#pontti@#";
    $dbname = "meuapp_ind0";
    $userId = '1';
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT user_tel FROM pnt_users where ID=".$userId;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
        $numAtual = $row["user_tel"];
      }
    } else {
        echo "0 results";
    }
        $conn->close();
        return $numAtual;
    }
    
    
/******************************************************************************/

/**
 * Do not add custom code / snippets here.
 * While Child Themes are generally recommended for customisations, in this case it is not
 * wise. Modifying this file means that your changes will be lost when an automatic update
 * of this theme is performed. Instead, add your customisations to a plugin such as
 * https://github.com/woothemes/theme-customisations
 */