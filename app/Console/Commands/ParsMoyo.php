<?php

namespace App\Console\Commands;

use App\HtmlDom\simple_html_dom;
use App\Models\Products;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ParsMoyo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pars:moyo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->pars();
        return Command::SUCCESS;
    }

    public function pars(){
        $client = new Client();
        $cc = $client->get('https://www.moyo.ua/telecommunication/smart/apple/', [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36 OPR/92.0.0.0',
            ]
        ])->getBody()->getContents();

        $html = new simple_html_dom($cc);
        $products = $html->find('.product-item');

        if (!empty($products)){
            foreach ($products as $product){
                if (!empty($product->find('.product-item_name')) && !empty($product->find('.product-item_price_current'))){
                    $name = trim($product->find('.product-item_name')[0]->text());
                    $price = trim(html_entity_decode($product->find('.product-item_price_current')[0]->text()));
                    $image = $product->find('.product-item_img img')[0]->src;
                    $product = Products::where('name', $name)->get();
                    if ($product->isEmpty()){
                        Products::create([
                            'name' => $name,
                            'price' => $price,
                            'image' => $image,
                        ]);
                    }else{
                        $product = $product->first();
                        $product->price = $price;
                        $product->save();
                    }
                }
            }
        }
    }
}
