<?php
namespace Common\Common;

/**
 * Forgery类
 * 生成虚假信息并写入数据库
 * @package Common\Common
 */
class Forgery {
    // 名字表
    private $name_list = array(
        'Aabbye', 'Aaron', 'Abagael', 'Abagail', 'Abbe', 'Abbey', 'Abbi', 'Abbie', 'Abbott', 'Abbra', 'Abby', 'Abdul', 'Abe', 'Abel', 'Abelard', 'Abeni', 'Abia', 'Abiba', 'Abie', 'Abigael', 'Baba', 'Baby', 'Bailey', 'Baird', 'Bairn', 'Bakula', 'Baldwin', 'Ballard', 'Bambi', 'Bancroft', 'Barak', 'Barb', 'Barbara', 'Barbie', 'Barclay', 'Bard', 'Barnaba', 'Barnabas', 'Barnaby', 'Barnardine', 'Cadence', 'Cady', 'Cael', 'Caesar', 'Cais', 'Caitlin', 'Caitlyn', 'Cal', 'Cala', 'Calandra', 'Calantha', 'Calder', 'Caldwell', 'Caleb', 'Calhoun', 'Calida', 'Calix', 'Calixte', 'Calla', 'Callia', 'Dacey', 'Dafydd', 'Dag', 'Dagmar', 'Dahila', 'Dahlia', 'Daisy', 'Dakota', 'Dale', 'Dalia', 'Dalila', 'Dalit', 'Dallas', 'Dalston', 'Dalton', 'Dalva', 'Damia', 'Damian', 'Damita', 'Damon', 'Earl', 'Eartha', 'Easter', 'Ebenezer', 'Ebony', 'Ed', 'Eden', 'Edgar', 'Edie', 'Edith', 'Edmund', 'Edna', 'Edsel', 'Edward', 'Edwin', 'Efrem', 'Egan', 'Egil', 'Eiji', 'DNF', 'Eileen', 'Fabian', 'Fairfax', 'Faith', 'Falkner', 'Fallon', 'Fanny', 'Farley', 'Farrah', 'Farrell', 'Fawn', 'Fay', 'Fedora', 'Felicia', 'Felix', 'Ferdinand', 'Fergus', 'Ferguson', 'Fern', 'Fernanado', 'Fernanda', 'Gabby', 'Gabriel', 'Gabrielle', 'Gaetan', 'Gaetane', 'Gafna', 'Gage', 'Gail', 'Gaiya', 'Galdys', 'Gale', 'Galen', 'Gali', 'Galina', 'Gallagher', 'Gallia', 'Galvin', 'Gannon', 'Gardner', 'Gareth', 'Hadley', 'Hakeem', 'Hal', 'Hale', 'Haley', 'Hall', 'Hallie', 'Halsey', 'Hamilton', 'Hamlet', 'Hamlin', 'Hampton', 'Hana', 'Hank', 'Hanley', 'Hanna', 'Hannah', 'Hannan', 'Hans', 'Happy', 'Ian', 'Ianna', 'Ianthe', 'Ida', 'Idalee', 'Idalia', 'Idana', 'Idande', 'Idania', 'Iggy', 'Ignatius', 'Igor', 'Ilana', 'Ilario', 'Ilene', 'Iliana', 'Ilit', 'Ilithya', 'Illias', 'Ilse', 'Jack', 'Jackie', 'Jackson', 'Jacob', 'Jacqueline', 'Jacques', 'Jade', 'Jaime', 'Jake', 'Jamal', 'James', 'Jamie', 'Jamil', 'Jan', 'Jana', 'Jane', 'Janelle', 'Janet', 'Janette', 'Jania', 'Kailey', 'Kaili', 'Kairos', 'Kaitlyn', 'Kala', 'Kaley', 'Kali', 'Kalil', 'Kalila', 'Kalinda', 'Kalli', 'Kaloosh', 'Kame', 'Kameko', 'Kameryn', 'Kami', 'Kamil', 'Kamilah', 'Kana', 'Kane', 'LaDon', 'LaRue', 'LaWana', 'Lacey', 'Lachlan', 'Lacy', 'Laddie', 'Ladonna', 'Lael', 'Lahela', 'Laina', 'Lainey', 'Laird', 'Lajos', 'Lajuan', 'Lajuana', 'Lakin', 'Lala', 'Lalasa', 'Lale', 'Mabel', 'Mac', 'MacKenzie', 'Madeline', 'Madge', 'Madison', 'Mae', 'Maggie', 'Mahalia', 'Maisie', 'Major', 'Malachi', 'Malcolm', 'Mallory', 'Malvin', 'Mamie', 'Mandel', 'Mandy', 'Manfred', 'Manuel', 'Nacia', 'Nada', 'Nadia', 'Nadiera', 'Nalani', 'Nale', 'Nan', 'Nancy', 'Nanette', 'Nani', 'Naomi', 'Nara', 'Nari', 'Natalie', 'Natasha', 'Nathaniel', 'Neal', 'Neala', 'Necia', 'Nedra', 'Oafa', 'Oakes', 'Oakley', 'Obadiah', 'Odelene', 'Odeletta', 'Odelia', 'Odell', 'Odella', 'Odetta', 'Ogden', 'Olaf', 'Olga', 'Olin', 'Oliver', 'Olivia', 'Olympia', 'Omar', 'Omega', 'Ona', 'Pable', 'Pablo', 'Paco', 'Paddy', 'Padro', 'Page', 'Paige', 'Palma', 'Palmer', 'Paloma', 'Palti', 'Pamela', 'Pandora', 'Pansy', 'Paris', 'Park', 'Parker', 'Parnell', 'Parry', 'Parson', 'Quella', 'Quentin', 'Querida', 'Quillan', 'Quin', 'Quincy', 'Quinlan', 'Quinn', 'Quinta', 'Quintin', 'Quinto', 'Quito', 'Rabi', 'Rachel', 'Rad', 'Radcliffe', 'Rae', 'Rafael', 'Rafe', 'Raffaello', 'Rafferty', 'Rainer', 'Rainy', 'Raleigh', 'Ralph', 'Ram', 'Ramiro', 'Ramon', 'Ramona', 'Ramsay', 'Ramses', 'Rance', 'Sabina', 'Sabrina', 'Sadie', 'Salim', 'Sally', 'Salome', 'Salvatore', 'Sam', 'Samantha', 'Samara', 'Samira', 'Samson', 'Samuel', 'Sancho', 'Sanders', 'Sandra', 'Sandy', 'Sanford', 'Sapphire', 'Sarah', 'Tab', 'Taban', 'Taber', 'Tabitha', 'Tacita', 'Tacy', 'Tad', 'Tadeo', 'Taffy', 'Tai', 'Taifa', 'Tailynn', 'Taima', 'Tait', 'Talbot', 'Talen', 'Talia', 'Taliesin', 'Taline', 'Talisa', 'Udell', 'Ugo', 'Ujana', 'Ula', 'Ulan', 'Ulani', 'Ulema', 'Ull', 'Ulla', 'Ulric', 'Ulysses', 'Uma', 'Umay', 'Umberto', 'Umeko', 'Umi', 'Ummi', 'Una', 'Unity', 'Upendo', 'Vail', 'Val', 'Vala', 'Valarie', 'Valdemar', 'Valencia', 'Valentina', 'Valentine', 'Valeria', 'Valerie', 'Valiant', 'Valtina', 'Van', 'Vance', 'Vandalin', 'Vanessa', 'Vangie', 'Vanida', 'Vanna', 'Vanya', 'Wade', 'Wafa', 'Waggoner', 'Wainwright', 'Waite', 'Wakefield', 'Walden', 'Waldo', 'Walker', 'Wallace', 'Wallis', 'Wally', 'Walt', 'Walta', 'Walter', 'Walton', 'Wanda', 'Wander', 'Waneta', 'Ward', 'Yale', 'Yancey', 'Yancy', 'Yannik', 'Yardley', 'Yasmine', 'Yeelves', 'Yehudi', 'Yetta', 'Yoko', 'Yoland', 'Yolanda', 'Yoninah', 'Yoona', 'Yori', 'Yorick', 'York', 'Yosef', 'Yoshiko', 'Yuk', 'Xavier', 'Xenos', 'Xerxes', 'Xiho', 'RTA', 'Ximenes', 'Zachariah', 'Zachary', 'Zaida', 'Zaide', 'Zalman', 'Zan', 'Zane', 'Zanna', 'Zara', 'Zared', 'Zarek', 'Zarifa', 'Zayn', 'Zea', 'Zebadiah', 'Zebra', 'Zebulon', 'Zed', 'Zedekiah', 'Zeki'
    );

    // 邮箱地址后缀表
    private $email_suffix_list = array('@126.com', '@qq.com', '@163.com', '@gmail.com', '@bbs.com', '@hotmail.com', '@sina.com', '@sohu.com', '@tom.com', '@msn.cn', '@yahoo.com');

    // 名字表长度
    private $name_list_len = 498;

    // 邮箱地址后缀表长度
    private $email_suffix_list_len = 10;

    // 类中存储表的名字
    private $table_name = '';

    // 类中存储需要随机处理的表的字段
    private $table_field = array();

    /**
     * 构造函数
     *
     * 参数为表的名字，不需要写入前缀，和M函数的参数一样
     *
     * @param $table_name
     */
    public function __construct($table_name) {
        $this->table_name = $table_name;
    }

    /**
     * 增加需要处理的字段
     *
     * 第一参数为表的字段的名称，注意要写正确
     * 第二参数为随机内容的种类，分别有：
     * name（用户名字），email（邮箱地址），password（MD5处理的密码，值为123），
     * title（标题，默认10单词左右，无标点），text（短文章，默认50单词左右，有标点），
     * number（数字，默认长度为5）
     * 第三参数为长度，对title，text，number有效，如果不填，则使用上述的默认长度
     *
     * @param $name
     * @param $type
     */
    public function add_field($name, $type, $len=0) {
        $this->table_field[$name] = array($type, $len);
    }

    /**
     * 生成随机内容并写入数据库
     *
     * 参数为需要生成的数量
     * 返回成功插入的数量
     *
     * @param $times
     * @return $count
     */
    public function fake($times) {
        $count = $times;
        $table = M($this->table_name);
        for ($i = 1; $i <= $times; $i++) {
            $data = array();
            // 根据类中存储的字段数组，生成对应的内容并循环写入$data中
            foreach ($this->table_field as $key => $value) {
                // 拼装类方法名称，得到如get_name()的方法名
                $method_name = get_.$value[0];
                $value = $this->$method_name($value[1]);
                $data[$key] = $value;
            }
            try {
                $table->data($data)->add();
            } catch (\Exception $e) {
                $count--;
                continue;
            }
        }
        return $count;
    }

    public function get_name($len) {
        $rand_index = rand(0, $this->name_list_len);
        $num = rand($len, 1000);
        return $this->name_list[$rand_index].$num;
    }

    public function get_email($len) {
        $pre_rand_index = rand(0, $this->name_list_len);
        $suf_rand_index = rand(0, $this->email_suffix_list_len);
        $num = rand($len, 1000);
        return $this->name_list[$pre_rand_index].$num.$this->email_suffix_list[$suf_rand_index];
    }

    public function get_password() {
        return md5('123');
    }


// 随机板块函数
    public function get_title($len=10) {
        if ($len <= 0) $len = 10;
        $result = '';
        $min = $len-3<0 ? 0 : $len-3;
        $word_num = rand($len-3, $len+3);
        for ($i = 0; $i < $word_num; $i++) {
            $rand_index = rand(0, $this->name_list_len);
            $result = $result . $this->name_list[$rand_index] . ' ';
        }
        return $result;
    }

    public function get_text($len=50) {
        if ($len <= 0) $len = 50;
        $result = 'a';
        $node = array(', ', '. ', '! ', '? ');
        $min = $len-5<0 ? 0 : $len-5;
        $word_num = rand($min, $len+5);
        for ($i = 0; $i < $word_num; $i++) {
            $rand_index = rand(0, $this->name_list_len);
            $result .= $this->name_list[$rand_index];
            if ($rand_index % $i == 0) {
                $node_rand_index = rand(0, 3);
                $result = $result . $node[$node_rand_index];
            } else {
                $result = $result . ' ';
            }
        }
        return $result;
    }

    public function get_number($len) {
        if ($len <= 0) return 0;
        $min = pow(10, $len-1);
        $max = pow(10, $len) - 1;
        return rand($min, $max);
    }
}