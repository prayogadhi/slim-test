<?php


use Phinx\Seed\AbstractSeed;

class Product extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = array(
            array(
                'name' => 'AROON 2.1 BLACK XS',
                'price' => '349000'
            ),
            array(
                'name' => 'BLACK PLEATS JOGGER S',
                'price' => '499000'
            ),
            array(
                'name' => 'BOYS DO CRY SHIRT XL',
                'price' => '299000'
            ),
            array(
                'name' => 'CARGO BLUE XL',
                'price' => '499000'
            ),
            array(
                'name' => 'CARSON BLUE XXL',
                'price' => '399000'
            )
        );

        $product = $this->table('product');
        $product->insert($data)->save();
    }
}
