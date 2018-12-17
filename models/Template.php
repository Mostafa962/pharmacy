<?php 
//CSS and Bootstrap Files 
class Template {
    //CSS and Bootstrap Files
    protected $css = array(
     	'bootstrap.css',
     	'bootstrap.min.css',
     	'font-awesome.min.css',
        'bootstrap-table.css',
        'styles.css',);
     //JS and jquery Files
    protected $js = array(
    	'jquery.js',
        'jquery-1.11.1.min.js',
        'jquery-2.2.3.min.js',
        'bootstrap.js',
        'bootstrap.min.js',
        'bootstrap-datepicker.js',
        'app.js',
        'additional-methods.min.js',
        'jquery.validate.min.js',
        'validation.js',
        );
    //CDN links
    protected $cdn = array(
        'https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i',
        'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',

    );
    protected $CSScdn = array(
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
           );
    //Main  Template's Pages of system 
    protected $template = array(
            'header.tpl',
            'sidebar.tpl',
            'content.tpl',
            'footer.tpl',);

	//to display CSS and Bootstrap files
    protected function CSS () {
        $array = array();
        foreach ($this->css as $css) {
            if (file_exists(CSS_PATH . $css)) {
                $array[] = '<link href="' . CSS_DIR . $css .
                         '" rel="stylesheet" type="text/css" media="all" />';
            }
        }
        return implode('', $array);
    }
	//to display Jabascript and jquery files
    protected function JS () {
        $array = array();
        foreach ($this->js as $js) {
            if (file_exists(JS_PATH . $js)) {
                $array[] = '<script type="text/javascript" src="' . JS_DIR . $js .
                         '"></script>';
            }
        }
        return implode('', $array);
    }
    //to get content delivery network of JS
    protected function CDN () {
        $array = array();
        foreach ($this->cdn as $cdn) {
            $array[] = '<script type="text/javascript" src="' . $cdn . '"></script>';
        }
        return implode('', $array);
    }
    //to get content delivery network of CSS
    protected function CSScdn () {
        $array = array();
        foreach ($this->CSScdn as $CSScdn) {
            $array[] = '<link href="'.$CSScdn.
                         '" id="font-awesome-style-css"rel="stylesheet" type="text/css" media="all" />';
        }
        return implode('', $array);
    }

    //To add Meta tags
    protected function metaTag ($name, $content) {
        return '<meta name="' . $name . '" content="' . $content . '" />';
    }
    //to Add Title Tag
    protected function titlTag ($title) {
        return '<title>' . $title . '</title>';
    }
    //to set meta encoding
    protected function Encoding ($encoding = "utf-8") {
        return '<meta charset="' . $encoding . '">';
    }
    //to add favicon
    protected function FavIcon () {
        return '<link rel="shortcut icon" href="images/medicens.jpg" type="image/x-icon">
        <link rel="icon" href="images/medicens.jpg" type="image/x-icon">';
    }
    //to call relative links(make relative links such media search from hostname)
    protected function setBase() {
        return '<base href="' . HOST_NAME . '">';
    }
    //To call template's pages
    protected function callTemplate() {
        foreach ($this->template as $template) {
            if(file_exists(TEMPLATE_PATH . $template)) {
                require_once (TEMPLATE_PATH . $template);
            }   
        }
    }
    //Call To Views Pages(such as :addUser,editUser,addMedcine,editMedcine...etc)
    protected function getView() {
        return (isset($_GET['view'])) ? $_GET['view'] : 'home';
    }
    //set what is view is required and return it 
    private function renderView() {
        $view = $this->getView();
        $requiredFile = VIEWS_PATH . $view . '.php';
        if(file_exists($requiredFile)) {
            require_once $requiredFile;
        }elseif ($view='home') {
            require_once (VIEWS_PATH .'contentView.php');
        }
    }
    //to active menus Items
    public function highlight($menu='admin') {
        $view = $this->getView();
        if($view == $menu) echo 'active';
    }
    //to display Errors Messages
    public static function failed($message){
         echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><strong>Failed!</strong>$message<br></center></div>";
    }
    //to display Deleted Messages
    public static function Deleted($message){
         echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><strong>Success!</strong>$message<br></center></div>";
    }
    //to display successful Messages
    public static function success($message){
         echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><strong>Success!</strong>$message<br></center></div>";
    }
    //to display system pages(admin,manager,pharmacy,cashier)
    public function SystemPages() {
        $page = '<!doctype html>';
        $page .= '<html lang="en">';
        $page .= '<head>';
        $page .= $this->titlTag('Welcome to PMS');
        $page .= $this->Encoding();
        $page .= $this->metaTag('keywords', 'pharmacy, managmen');
        $page .= $this->metaTag('viewport', 'width=device-width, initial-scale=1');
        $page .= $this->metaTag('description', 'This is pharmacy managmen system');
        $page .= $this->setBase();
        $page .= $this->FavIcon();
        $page .= $this->CSS();
        $page .= $this->CDN();
        $page .= '<script src="js/jquery-3.2.1.min.js"></script></head><body>';
        echo $page;
        $this->callTemplate();
        $jsFiles = $this->JS();
        echo $jsFiles;
        echo '</body></html>';
    }
    //to display login page
    public  function loginPage(){
        $page = '<!doctype html>';
        $page .= '<html lang="en">';
        $page .= '<head>';
        $page .= $this->titlTag('Login');
        $page .= $this->Encoding();
        $page .= $this->metaTag('viewport', 'width=device-width, initial-scale=1');
        $page .= $this->setBase();
        $page .= $this->FavIcon();
        $page .= $this->CSS();
        $page .= $this->CDN();
        $page .= '</head><body style="background-image:url(\'images/cover.jpg\');background-color:rgba(0, 0, 0, 0.5);background-size:cover;overflow-x: hidden;">';
        echo $page;
            require_once (TEMPLATE_PATH . 'login.tpl');
        $jsFiles = $this->JS();
        echo $jsFiles;
        echo '</body></html>';
    }
}