<?php
// class Plan{
//     private $id;
//     private $name;
//     private $price;
//     public function __construct($id,$name,$price){
//        $this->id = $id;
//        $this->name = $name;
//        $this->price = $price;
//     }
//     public function getId(){
//         return $this->id;
//     }

//     public function getName(){
//       return $this->name;
//     }

//     public function getPrice(){
//        return $this->price;
//     }
// }

// class Network {
//     private $id;
//     private $name;
//     private $plans = [];

//     public function __construct($id, $name) {
//         $this->id = $id;
//         $this->name = $name;
//     }
//     public function addPlan(Plan $plan){
//        $this->plans[$plan->getId()] = $plan;
//     }
//     public function getPlans(){
//         return $this->plans;
//     }
//     public function getPlan($planId){
//         return $this->plans[$planId] ?? null;
//     }
//     public function getNetName(){
//         return $this->name;
//     }
//     public function getNetId(){
//         return $this->id;
//     }
// }

// class NetworkManager{
//     private $networks = [];
//     public function addNetwork(Network $network){
//         //  ------------ add network by id------------
//         $this->networks[$network->getNetId()] = $network;
//         // ------------add network by name------------
//         // $this->networks[$network->getNetName()] = $network;
//     }
//     public function getNetwork($networkName) {
//         return $this->networks[$networkName] ?? null;
//     }
//     public function getNetworkNames() {
//         return array_keys($this->networks);
//     }
// }

// $network1 = new Network(1, "MTN");
//            // --------------MTN SME data plans and  prices-------------------
// $network1->addPlan(new Plan(166, 'SME', [
//     'price' => 260,
//     'size'=>'1GB', 
//     'validity'=>'30 days'
//      ]));
// $network1->addPlan(new Plan(167, 'SME', [
//     'price' => 525,
//     'size'=>'2GB', 
//     'validity'=>'30 days'
//         ]));
// $network1->addPlan(new Plan(168, 'SME', [
//     'price' => 777,
//     'size'=>'3GB', 
//     'validity'=>'30 days'
//         ]));
//             // --------------MTN gipting data plans and  prices-------------------
// $network1->addPlan(new Plan(199, 'GIPTING', [
//     'price' => 3880,
//     'size'=>'12GB', 
//     'validity'=>'30 days'
//         ]));
// $network1->addPlan(new Plan(204, 'GIPTING', [
//     'price' => 10670,
//     'size'=>'40GB', 
//     'validity'=>'30 days'
//         ]));
//             // ------------MTN co'oprative gipting --------------------
// $network1->addPlan(new Plan(213, 'CORPORATE GIFTING', [
//     'price' => "₦260.0",
//     'size'=>'1GB', 
//     'validity'=>'30 days'
//         ]));
// $network1->addPlan(new Plan(215, 'CORPORATE GIFTING', [
//     'price' => "₦530.0",
//     'size'=>'2GB', 
//     'validity'=>'30 days'
//         ]));




// $network2 = new Network(3, 'Airtel');
// $network2->addPlan(new Plan(4, 'SME', ['1GB' => 450, '2GB' => 850]));
// $network2->addPlan(new Plan(5, 'Gifting', ['500MB' => 280, '1.5GB' => 1100]));
// $network2->addPlan(new Plan(6, 'Cooperative', ['10GB' => 2900, '20GB' => 4900]));

// $networkManager = new NetworkManager();
// $networkManager->addNetwork($network1);
// $networkManager->addNetwork($network2);

// $selectedNetworkName =1;
// $selectedNetwork = $networkManager->getNetwork($selectedNetworkName);
//   $plansArr=[];
//     foreach ($selectedNetwork->getPlans() as $plan) {
//        $plansArr[]=[
//                 "name"=>$plan->getName(),
//                 "id" =>$plan->getId()
//             ];
//     }
    
//     $selectedPlanId = 166; // For example, selecting the SME plan
//         $selectedPlan = $selectedNetwork->getPlan($selectedPlanId);
    
//         if ($selectedPlan) {
//             //  echo "Prices for {$selectedPlan->getName()}:" . PHP_EOL;
//             foreach ($selectedPlan->getPrice() as $package => $price) {
//                 //  echo "- $package: $price" . PHP_EOL;
//             }
//         } 

class Plan{
    private $id;
    private $size;
    private $price;
    private $validity;

    public function __construct($id,$size,$price,$validity){
       $this->id = $id;
       $this->size = $size;
       $this->price = $price;
       $this->price = $validity;
    }
    public function getId(){
        return $this->id;
    }
    public function getSize(){
        return $this->size;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getValidity(){
        return $this->validity;
    }

}

class PlanType {
    private $id;
    private $name;
    private $plans = [];

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function addPlan(Plan $plan) {
        $this->plans[$plan->getId()] = $plan;
    }

    public function getPlans() {
        return $this->plans;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}
class Network {
    private $id;
    private $name;
    private $planTypes = [];

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function addPlanType(PlanType $planType) {
        $this->planTypes[$planType->getId()] = $planType;
    }

    public function getPlanTypes() {
        return $this->planTypes;
    }

    public function getPlanType($planTypeId) {
        return $this->planTypes[$planTypeId] ?? null;
    }

    public function getNetName() {
        return $this->name;
    }

    public function getNetId() {
        return $this->id;
    }
}
class NetworkManager {
    private $networks = [];

    public function addNetwork(Network $network) {
        $this->networks[$network->getNetId()] = $network;
    }

    public function getNetwork($networkId) {
        return $this->networks[$networkId] ?? null;
    }

    public function getNetworkNames() {
        return array_keys($this->networks);
    }
}
// MTN Network with SME and GIFTING PlanTypes
$network1 = new Network(1, "MTN");
$smeMTN = new PlanType(1, 'SME');
$smeMTN->addPlan(new Plan(101, '1GB', 260, '30 days'));
$smeMTN->addPlan(new Plan(102, '2GB', 525, '30 days'));

$giftingMTN = new PlanType(2, 'GIFTING');
$giftingMTN->addPlan(new Plan(201, '12GB', 3880, '30 days'));
$giftingMTN->addPlan(new Plan(202, '40GB', 10670, '30 days'));

$network1->addPlanType($smeMTN);
$network1->addPlanType($giftingMTN);
// Airtel Network with SME and GIFTING PlanTypes
$network2 = new Network(2, "Airtel");
$smeAirtel = new PlanType(3, 'SME');
$smeAirtel->addPlan(new Plan(103, '1GB', 450, '30 days'));
$smeAirtel->addPlan(new Plan(104, '2GB', 850, '30 days'));

$giftingAirtel = new PlanType(4, 'GIFTING');
$giftingAirtel->addPlan(new Plan(203, '10GB', 2900, '30 days'));
$giftingAirtel->addPlan(new Plan(204, '20GB', 4900, '30 days'));

$network2->addPlanType($smeAirtel);
$network2->addPlanType($giftingAirtel);

// Glo Network with SME PlanType only
$network3 = new Network(3, "Glo");
$smeGlo = new PlanType(5, 'SME');
$smeGlo->addPlan(new Plan(105, '500MB', 200, '30 days'));
$smeGlo->addPlan(new Plan(106, '1GB', 350, '30 days'));

$network3->addPlanType($smeGlo);

// Add networks to manager
$networkManager = new NetworkManager();
$networkManager->addNetwork($network1);
$networkManager->addNetwork($network2);
$networkManager->addNetwork($network3);

// $planTypeOptions = [];
// foreach ($planTypes as $planType) {
//     $planTypeOptions[] = [
//         'PlanType_id' => $planType->getId(),
//         'PlanType_name' => $planType->getName()
//     ];
// }
// print_r($planTypeOptions);


class PlanList{
    private $id;
    private $name;
    private $amount;
    public function __construct($id,$name,$amount){
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getAmount(){
        return $this->amount;
    }
}
 class Cable{
    private $name;
    private $id;
    private $plans = [];
    public function __construct($name,$id) {
        $this->name = $name;
        $this->id = $id;
    }
    public function addPlan(PlanList $planList){
      $this->plans[$planList->getId()] = $planList;
    }
    public function getPlans(){
        return $this->plans;
    }
    public function getId(){
        return $this->id;
    }
}

$cable1 = new Cable(1,"GOTV");
$cable1->addPlan(new PlanList(2,"GOTV max",7200));
$cable1->addPlan(new PlanList(16,"GOtv Jinja",3300));
$cable1->addPlan(new PlanList(17,"GOtv Smallie-monthly",1575));

print_r($cable1->getPlans());

?>
