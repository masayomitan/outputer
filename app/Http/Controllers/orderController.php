<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use Exception;

class OrdersController extends AppController
{

    public function isAuthorized($user)
    {
        return true;
    }

    public function initialize()
    {
        parent::initialize();
        $this->Stocks = TableRegistry::get('stocks');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $orders = $this->paginate($this->Orders);

        $this->set(compact('orders'));



    }


    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);

        $this->set('order', $order);
    }



    public function order()
    {
        $getSession = $this->request->getSession()->read('Auth.User.user_types');
        try{
          $order = $this->Orders->newEntity();
          $connection = ConnectionManager::get('default');
          $selectSql = 'SELECT `stock_id`,`stock_name`,`stock_price`, `stock_number` FROM stocks';
          $result = $connection->execute($selectSql);
          $stockInfo = array();
          foreach ($result as $key => $val) {
            $array = array('stock_id' => $val['stock_id'], 'stock_name' =>$val['stock_name'], 'stock_price' => $val['stock_price'] ,'stock_number' => $val['stock_number']);
            array_push($stockInfo ,$array);
        }

        $stockName = array();
          foreach($stockInfo as $key2 => $val2){
            array_push($stockName, $val2['stock_name']
            );
          }
        $stockNumber = array();
          foreach($stockInfo as $key2 => $val2){
            array_push($stockNumber, $val2['stock_number']
            );
          }


        if($this->request->is('post')){
            // $stock_id = $this->request->getData('stock_id');
            $stock_name = $this->request->getData('order_name');
            $stock_number = $this->request->getData('order_number');
            $order->order_name = $stockName[$stock_name];
            $stockAmount = $stockNumber[$stock_name] - ($stock_number);


              if ($stockAmount < -1){
                $this->Flash->error(__('在庫足りないです。'));
                return $this->redirect(['action' => 'order']);
                } else{

            $stockId = array();
             foreach($stockInfo as $keyId => $valId){
                array_push($stockId, $valId['stock_id']);
             }

              $currentStockId = $stockId[$stock_name];
              $stock = $this->Stocks->get($currentStockId);
              $stock = $this->Stocks->patchEntity($stock ,array('stock_number' => $stockAmount));

              $order->order_number = $stock_number;
              $stock_price = $stockInfo[$stock_name]['stock_price'];
              $order->order_price = $stock_price;
              $order->order_total = $stock_price * $stock_number;
              $order->status_name = '発注確認';
             }
              if ($this->Orders->save($order) && $this->Stocks->save($stock)) {
                  $this->Flash->success(__('正常に発注されました。'));
                  return $this->redirect(['action' => 'index']);
              }

          }
        }catch( Exception $e){
          $this->Flash->error(__('error'));
          printf('Err: {%s}', $e->getMessage());
          return false;
        }
        $this->set(compact('order','stockInfo','stockName','getSession'));
    }


    public function confirmOrder($id = null)
    {
        $orders = $this->paginate($this->Orders);
        $getSession = $this->request->getSession()->read('Auth.User.user_types');
        try{
          $connection = ConnectionManager::get('default');
          if($this->request->is(['patch', 'post'])){
            foreach($this->request->getData() as $key => $val){
              $order = $this->Orders->get($val);
              $order = $this->Orders->patchEntity($order ,array('status_name' => '発注状態'));
              $this->Orders->save($order);
            }
            $this->Flash->success(__('チェック完了。ステータスを発注状態に変更しました。'));

            return $this->redirect(['action' => 'index']);
          }
        }catch(Exception $e){
          $this->Flash->error(__('error'));
          printf('Err: {%s}', $e->getMessage());
          return false;
        }
        $this->set(compact('orders','getSession'));
      }


    public function orderCheck()
    {
        $orders = $this->paginate($this->Orders);
        $getSession = $this->request->getSession()->read('Auth.User.user_types');
        try{
          $connection = ConnectionManager::get('default');
          if($this->request->is(['patch', 'post'])){
            foreach($this->request->getData() as $key => $val){
              $order = $this->Orders->get($val);
              $order = $this->Orders->patchEntity($order ,array('status_name' => '発注済み'));
              $this->Orders->save($order);
            }
            $this->Flash->success(__('チェック完了。ステータスを発注済みにしました。'));

            return $this->redirect(['action' => 'index']);
          }
        }catch(Exception $e){
          $this->Flash->error(__('error'));
          printf('Err: {%s}', $e->getMessage());
          return false;
        }
        $this->set(compact('orders','getSession'));
    }


    public function pickupCheck()
    {
        $getSession = $this->request->getSession()->read('Auth.User.user_types');
        $orders = $this->paginate($this->Orders);
        try{
          $connection = ConnectionManager::get('default');
          if($this->request->is(['patch', 'post'])){
            foreach($this->request->getData() as $key => $val){
              $order = $this->Orders->get($val);
              $order = $this->Orders->patchEntity($order ,array('status_name' => '発注受け取り済み'));
              $this->Orders->save($order);
            }
            $this->Flash->success(__('チェック完了。ステータスを発注受け取り済みにしました。'));

            return $this->redirect(['action' => 'index']);
          }
        }catch(Exception $e){
          $this->Flash->error(__('error'));
          printf('Err: {%s}', $e->getMessage());
          return false;
        }
        $this->set(compact('orders','getSession'));
    }


}
