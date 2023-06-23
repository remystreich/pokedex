<?php
class Form{
    /**
     * 
     */
    private $data;

    public function __construct($data = array()){
        $this->data =$data;
    }

    public function input($name, $type, $label,$value){
        echo '  <div>
                    <label for="'.$name.'" class="block mb-2 text-sm font-medium text-gray-900">'.$label.'</label>
                    <input type="'.$type.'" name="'.$name.'" id="'.$name.'" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="'.$name.'" value="'.$value.'"  required>
                </div>';
    }

    public function submit(){
        echo '<div class="flex items-center">
                <button type="submit" class="w-6/12 mx-auto  text-white text-xl bg-amber-400 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-2xl text-sm px-5 py-2.5 text-center ">Valider</button>
                </div>        
                ';
    }
}
?>
