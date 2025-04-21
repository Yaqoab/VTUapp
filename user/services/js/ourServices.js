class DomManipulator {
  constructor() {}

  elementById(id) {
    return document.getElementById(id);
  }

  elementByClassName(id) {
    return document.getElementsByClassName(id);
  }
}

class OurServices extends DomManipulator {
  constructor() {
    super();
  }
  loader(){
    return this.elementById('loading');
  }
  // Reference for making HTTP request or sending data


  // sendAndRequest = (endPoint, method, data) => {
  //   return new Promise((resolve, reject) => {
  //     const http = new XMLHttpRequest();
  //     http.open(method, endPoint, true);

  //   http.addEventListener("load", () => {
  //       if (http.readyState === 4) {
  //             if (http.status === 200) {
  //               resolve(JSON.parse(http.responseText));
  //             } else {
  //               reject({ error: `Error occurred: (${http.statusText})` });
  //             }
  //       } else {
  //         reject({ error: `Error occurred: (${http.statusText})` });
  //       }
  //   });

  //     method = method.toLowerCase();
  //     if (method === "post") {
  //       http.setRequestHeader("Accept", "application/json");
  //       http.send(data);
  //     }
  //     if (method === "get") {
  //       http.setRequestHeader("Accept", "application/json");
  //       http.send();
  //     }
  //   });
  // };



  
  sendRequest = async (method, endPoint, data = null) => {
    const defaultHeaders = {
      "Accept": "application/json",
      "Content-Type": "application/json",
    };
  
    try {
      const options = {
        method: method.toUpperCase(),
        headers: defaultHeaders,
      };
  
      if (method.toLowerCase() === "post" && data) {
        options.body = data instanceof FormData ? data : JSON.stringify(data);
  
        if (data instanceof FormData) {
          delete options.headers["Content-Type"]; // Let the browser set it
        }
      }
  
      const response = await fetch(endPoint, options);
  
      if (!response.ok) {
        throw new Error(`Error occurred: ${response.statusText}`);
      }
  
      return await response.json();
    } catch (error) {
      return Promise.reject({ error: error.message });
    }
  };






  // HTML select option method
  createOption = (value, text, className, amount = null) => {
    const option = document.createElement("option");
    option.value = value;
    option.text = text;
    option.className = className;
    if (amount !== null) {
      option.setAttribute("data-amount", amount);
    }
    return option;
  };
    //  ----------------DATA BUNDLE START----------------
  dataBundle = (id,catId) => {
    const userId = id;
    const cat_id = catId;
    const form = this.elementById("dataform");
    const network = this.elementByClassName("net-card");
    const planType = this.elementById("plan-type");
    const planList = this.elementById("planlist");
    const load=this.loader();

    // Function to create option elements
    const createOption = (value, text, className, amount = null) => {
      const option = document.createElement("option");
      option.value = value;
      option.text = text;
      option.className = className;
      if (amount !== null) {
        option.setAttribute("data-amount", amount);
      }
      return option;
    };

    // Function to handle price list click events
    let selectedNetwork = "";
    const handlePriceListClick = async (price) => {
      try {
        // const secondRes = await this.sendAndRequest(
        //   `./../user/services/data/processData.php?planId=${price}`,
        //   "GET",
        //   ""
        // );
        const secondRes = await this.sendRequest("GET",`./../user/services/data/processData.php?planId=${price}`);
        return secondRes;
      } catch (error) {
        console.error(error);
      }
      // this.sendRequest("GET",`./../user/services/data/processData.php?planId=${price}`)
      // .then(data => {
      //   return data;
      // })
      // .catch(error => console.error(error))

    };

    // Function to set up event listeners for network cards
    const setupNetworkCardListeners = () => {
      for (const card of network) {
        card.addEventListener("click", async () => {
          // Remove all (selected) class values
          for (const cards of network) {
            cards.classList.remove("selected");
            cards.children[0].classList.remove("layer");
          }
          // Add new selected value
          card.classList.add("selected");
          card.children[0].classList.add("layer");

          // Get network selected
           selectedNetwork = card.id;

          // Clear existing selected values and add new
          planType.innerHTML = '<option value="">Select plan type</option>';
          planList.innerHTML = '<option value="">Select price list</option>';
          try {
            // Plan type
            const res = await this.sendRequest("GET",`./../user/services/data/processData.php?network=${selectedNetwork}`);

            if (res.status === "success") {
              res.data.forEach((element) => {
                const option = createOption(
                  element.plan_id,
                  element.Plan_name,
                  "planprice"
                );
                planType.add(option);
              });
              console.log(res.data);

              // Data plan list
              planType.addEventListener("change", async () => {
                const selectedOption = planType.options[planType.selectedIndex];
                if (selectedOption.classList.contains("planprice")) {
                  const selectedValue = selectedOption.value;

                  try {
                    // Call async function and await its result
                    const res = await handlePriceListClick(selectedValue);
                    console.log(res);

                    // Add new options to planList
                    planList.innerHTML ='<option value="">Select price list</option>';
                    res.data.forEach((element) => {
                      const option = createOption(
                            element.data_id,
                            `${element.size} ${element.Plan_name} = ${element.Validity}`,
                            "pricelist",
                            element.Amount
                      );
                      planList.add(option);
                    });
                  } catch (error) {
                    console.error(error);
                  }
                }
              });
              // Post form data
            } else {
              console.log("No plan available");
            }
          } catch (error) {
            console.error(error);
          }
        });
      }
    };

    // Load all contents
    document.addEventListener("DOMContentLoaded", () => {
      setupNetworkCardListeners();
    });

    // Post form data
    form.addEventListener("submit", async (e) => {
          e.preventDefault();
          const errNetwork=this.elementById('errNetwork');
          const errPlan=this.elementById('errPlan');
          const errPrice=this.elementById('errPrice');
          const errPhone=this.elementById('errPhone');
          const errPin=this.elementById('errPin');
          load.style.display="block";

          const formdata = new FormData(form);
          // Get the data-amount attribute value
          const selectedOption = planList.options[planList.selectedIndex];
         
          if (selectedNetwork) {
            formdata.append("network", selectedNetwork);
          }
      if (selectedOption) {
            const amount = selectedOption.dataset.amount;
            formdata.append("userId", userId);
            formdata.append("amount", amount);
            formdata.append("cat_id", cat_id);

        try {
          const res = await this.sendRequest("POST",`./../user/services/data/processData.php`,formdata);

          load.style.display="none";
          if (res.status === "success") {
            errNetwork.textContent="";
            errPlan.textContent = "";
            errPrice.textContent = "";
            errPhone.textContent = "";
            errPin.textContent = "";
            const resData = res.data;
            console.log(resData);
          }else{
            errNetwork.textContent = res.data.network;
            errPlan.textContent = res.data.dataPlan;
            errPrice.textContent = res.data.dataPrice;
            errPhone.textContent = res.data.phone;
            errPin.textContent = res.data.pin;

            // console.log(res.network);
          }
        } catch (error) {
          console.error(error);
        }
      } else {
        console.error("No price list option selected");
      }
    });
  };
        // ------------------DATA BUNDLE END---------------------


        // ------------------AIRTIME START-----------------------

        airtime(id,catId){
          const userId  = id;
          const cat_id  = catId;
          const form    = this.elementById('airtimeform');
          const network = this.elementByClassName("net-card");
          const load    = this.loader();
          // let selectedNetwork = null;

           for (const card of network) {
              //  remove all selected networks
              card.addEventListener("click",()=>{
              
                 for (const cards of network) {
                    cards.classList.remove("selected");
                    cards.children[0].classList.remove("layer")
                 }
                    card.classList.add("selected");
                    card.children[0].classList.add("layer")
                    // Get network selected
                    const selectedNetwork = card.id;
                     // Update hidden input field with selected network
                    this.elementById('selected-network').value = selectedNetwork;
                    });


           }
             
                form.addEventListener("submit",async (e)=>{
                  e.preventDefault()
                  const errNetwork=this.elementById('errNetwork');
                  const errPhone=this.elementById('errPhone');
                  const errAmount=this.elementById('errAmount');
                  const errPin=this.elementById('errPin')
                  load.style.display="block";

                  const formdata=new FormData(form);
                      formdata.append("userId", userId);
                      formdata.append("cat_id", cat_id);
                try {
                  const res = await this.sendRequest("POST",
                    `./../user/services/airtime/processAirtime.php`,
                    formdata
                  );
                  load.style.display="none"
                  // console.log(res);
                  if (res.status === "success") {
                    errNetwork.textContent="";
                    errPhone.textContent="";
                    errAmount.textContent="";
                    errPin.textContent="";
                    // check if successful from API provider
                        if (res.status === "successful") {
                            console.log(res.data);
                        }else{
                             console.log(res.data);
                        }
                  }else{
                    console.log(res);
                    errNetwork.textContent=res.data.network;
                    errPhone.textContent=res.data.phone;
                    errAmount.textContent=res.data.amount;
                    errPin.textContent=res.data.pin;
                  }
                } catch (error) {
                  console.error(error);
                }
              })
          
        }
                 // ------------------TV SUBSCRIPTION START-----------------------

                tvSubscription(id,catId){
                 const form         = this.elementById('tvCable');
                 const tvOptionCont = this.elementById("cableNames");
                 const tvPlanList   = this.elementById("cablePlan");
                 const getAmount    = this.elementById("amount")
                 const userId       = id;
                 const cat_id       = catId;
                const load          = this.loader();

                tvOptionCont.addEventListener("change", async()=>{
                      const selectOption=tvOptionCont.options[tvOptionCont.selectedIndex].value;
                      // clear selected price before change
                      tvPlanList.innerHTML = '<option  value="">Select cable price</option>';
                      try {
                        const res = await this.sendRequest("GET",`./../user/services/tv/processTv.php?tv=${selectOption}`,
                                    );
                         
                        res.data.forEach((el)=>{
                            //value, text, className, amount
                          const option = this.createOption(
                            el.cablePlanID,
                           ` ${el.planName} ${el.amount}`,
                           "plans-price",
                           el.amount
                          );
                          tvPlanList.add(option);
                          // console.log(el.planName);
                        })
                        
                      } catch (error) {
                        console.error(error);
                      }
                    });

                    tvPlanList.addEventListener("change", ()=>{
                         const selectedOption = tvPlanList.options[tvPlanList.selectedIndex];
                         const amount = selectedOption.dataset.amount;
                         getAmount.value = amount;
                         console.log(amount);
                    })
                

                  form.addEventListener("submit", async (event)=>{
                    event.preventDefault();
                    const errName   = this.elementById("errName");
                    const errPlan   = this.elementById("errPlan");
                    const errIUC    = this.elementById("errIUC");
                    const errAmount = this.elementById("errAmount");
                    const errPin    = this.elementById("errPin");
                    load.style.display="block"

                    const formdata = new FormData(form);
                    
                    // const selectedOption = tvPlanList.options[tvPlanList.selectedIndex];
                    // const amount = selectedOption.dataset.amount;
                    //       formdata.append("amounts",amount);
                          formdata.append("userId",userId);
                          formdata.append("cat_id", cat_id);
                    // console.log(selectedOption.dataset.amount);
                    try {
                      const res = await this.sendRequest("POST",`./../user/services/tv/processTv.php`, formdata
                            );
                            load.style.display="none"
                        
                        if (res.status == "success") {
                          console.log(res);
                          errName.textContent   = "";
                          errPlan.textContent   = "";
                          errIUC.textContent    = "";
                          errAmount.textContent = "";
                          errPin.textContent    = "";
                        }else{
                          errName.textContent   = res.data.cable;
                          errPlan.textContent   = res.data.cablePlan;
                          errIUC.textContent    = res.data.iuc;
                          errAmount.textContent = res.data.amount;
                          errPin.textContent    = res.data.pin;
                        }
                    } catch (error) {
                      console.error(error);
                    }

                  });
                }

                  // ------------------TV SUBSCRIPTION END-----------------------

                  // -----------------ELECTRICITY START--------------------------
                  electricity(id){
                    const form = this.elementById('electricity');
                    const userId = id;
                    const load=this.loader();

                    form.addEventListener("submit",async (e)=>{
                        e.preventDefault();
                        const errName   = this.elementById("errName");
                        const errMeter  = this.elementById("errMeter");
                        const errType   = this.elementById("errType");
                        const errAmount = this.elementById("errAmount");
                        const errPhone  = this.elementById("errPhone");
                        const errPin    = this.elementById("errPin");
                        
                        load.style.display="block"

                        const formdata = new FormData(form);
                              formdata.append("userId",userId);
                        try {
                          const res = await this.sendRequest("POST",
                            `./../user/services/electricity/processElectric.php`,
                            formdata
                            );
                            load.style.display="none"

                            if (res.status == "successful") {
                              console.log(res);

                              errName.textContent   = "";
                              errMeter.textContent  = "";
                              errType.textContent  = "";
                              errAmount.textContent = "";
                              errPhone.textContent  = "";
                              errPin.textContent    = "";
                            } else {
                              errName.textContent   = res.data.cable;
                              errMeter.textContent  = res.data.meter;
                              errType.textContent  = res.data.meterType;
                              errAmount.textContent = res.data.amount;
                              errPhone.textContent = res.data.phone;
                              errPin.textContent    = res.data.pin;
                            }
                        } catch (error) {
                          console.error(error);
                        }
                    });
                  }
                  // -------------------ELECTRICITY END----------------------

                  // ------------------EXAM PIN START------------------------
            exams(id){
              const form           = this.elementById("exam");
              const examOptionCont = this.elementById("examname");
              const amount         = this.elementById("amount");
              const quantity       =this.elementById("quantity");
              const userId = id;
              const load=this.loader();
             
              let selectedPrice = 0;

              function updateAmount(){
                const qty = parseInt(quantity.value) || 0;
                const total = selectedPrice * qty;
                amount.value = total;
              }
             examOptionCont.addEventListener("change", ()=>{
              const selectedOption = examOptionCont.options[examOptionCont.selectedIndex];
               selectedPrice = parseFloat(selectedOption.getAttribute("data-price")) || 0;
                  updateAmount();
             });

             quantity.addEventListener("change", () => {
              updateAmount();
              });
              updateAmount();

              form.addEventListener("submit", async (e)=>{
                e.preventDefault();
                 const errExam     = this.elementById("errExam");
                 const errquantity = this.elementById("errquantity");
                 const errPin      = this.elementById("errPin");

                 load.style.display = "block";

                const formdata = new FormData(form);
                      formdata.append("userId",userId);
                     
                  try {
                const res = await this.sendRequest("POST",`./../user/services/exam/processExam.php`,formdata);
               
                        load.style.display="none";

                        console.log(res);
                      if (res.status === "successful") {
                        errExam.textContent     = "";
                        errquantity.textContent = "";
                        errPin.textContent      = "";
                      }else{
                        errExam.textContent     = res.data.exam;
                        errquantity.textContent = res.data.quantity;
                        errPin.textContent      = res.data.pin;
                      }
                        
                      } catch (error) {
                        console.error(error)
                      }
              });
             
            }
                // -----------------EXAM PIN END------------------------
              
}
