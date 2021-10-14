<?php


echo '<html>'."\n";
echo '<head>'."\n";
echo '<title>První</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<div class="container">'."\n";

echo '<h1>OOP</h1>'."\n";

class A
{
    function __construct()
    {
        echo 'Class A<br>'."\n";
    }
}

class B extends A
{
    function __construct()
    {
        parent::__construct();
        echo 'Class B<br>'."\n";
    }
}

$a = new A();
$b = new B();

class Point
{
    protected int $x;
    protected int $y;

    public function __construct(int $x, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function print_point()
    {
        echo "Point x=$this->x, y=$this->y<br>"."\n";
    }
}

$p1 = new Point(4, 5);
$p1->print_point();

$p2 = new Point(9);
$p2->print_point();

$p2->y = 5;
$p2->print_point();

class Fruit
{
    protected string $name;
    protected string $color;

    public function __construct(string $name = "", string $color = "")
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function setColor($name, $value)
    {
        $this->color = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function intro()
    {
        echo "Ovoce $this->name má barvu $this->color";
    }
}

class Strawberry extends Fruit
{
    public int $weight;

    public function __construct(string $name = "", string $color = "", int $weight = 0)
    {
        parent::__construct($name, $color);
        $this->weight = $weight;
    }

    public function intro()
    {
        echo parent::intro() . " a váží $this->weight g";
    }
}

$str = new Strawberry("Jahoda", "Červená", 500);
$str->intro();

echo '</div>'."\n";
echo '</body>'."\n"; 
echo '</html>'."\n"; 

?>
