const sendRequest = async (method, endPoint, data = null) => {
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

  const container  = document.getElementById("container");
     const    loading   = document.getElementById("loading");
         loading.style.display='block'
   const URLParams = new URLSearchParams(window.location.search);
   const catName   = URLParams.get('catname');
   const userId    = URLParams.get('uId');
   const ref = URLParams.get('ref');
   
 
  async function displayTransaction(){
    // container.innerHTML = "";
 try {
    const res = await sendRequest("GET",`./../user/pages/transac_history/processTransaction.php?catname=${catName}&uId=${userId}&ref=${ref}`,);
    loading.style.display='none';
    const data=res.details;
    console.log(data);
    if (res.category === 'data') {  
        container.innerHTML =   `
              <div class="w-100 position-relative">
                <span class="h4 card-title" id="transfertitle">${res.category}</span>
            </div>
            <hr>
            <h5 class="card-title">Transaction Details</h5>
            <p class="card-text"><strong>Status:</strong> <span>${data.status}</span></p>
            <p class="card-text"><strong>phone number:</strong> <span>${data.phone}</span></p>
            <p class="card-text"><strong>Plan type:</strong> <span>${data.plan_type}</span></p>
            <p class="card-text"><strong>Plan size:</strong> <span>${data.data_plan}</span></p>
            <p class="card-text"><strong>Network:</strong> <span>${data.network}</span></p>
            <p class="card-text"><strong>Date:</strong> <span>${data.date}</span></p>
            <p class="card-text"><strong>ref:</strong> <span>${data.reference}</span></p>
            </div>
            <div class="card-footer text-muted">
                Thank you for using our service!
            </div>
                `;
                return;
    }if(res.category === "airtime") {
              container.innerHTML =   `
              <div class="w-100 position-relative">
              <span class="h4 card-title" id="transfertitle">${res.category}</span>
            </div>
            <hr>
            <h5 class="card-title">Transaction Details</h5>
            <p class="card-text"><strong>Status:</strong> <span>${data.status}</span></p>
            <p class="card-text"><strong>phone number:</strong> <span>${data.phone}</span></p>
            <p class="card-text"><strong>Network:</strong> <span>${data.network}</span></p>
            <p class="card-text"><strong>Date:</strong> <span>${data.date}</span></p>
            <p class="card-text"><strong>ref:</strong> <span>${data.reference}</span></p>
            </div>
            <div class="card-footer text-muted">
                Thank you for using our service!
            </div> `;
                return;
    }if (res.category === "transfer") {
              function maskPhone(phone) {
          if (phone.length !== 11) return phone;

          // Keep first 4 and last 3 digits, mask the middle
          return phone.slice(0, 4) + '****' + phone.slice(-3);
        }
            const isSender  = data.sender_id == id;
            const amountVal = isSender ? `- ₦${data.amount}` :`+ ₦${data.amount}`;
            const title     = isSender ? `Sent` :`Recieved`;
            
            const senderAccMasked = isSender ? data.senderAcc : maskPhone(data.senderAcc);
            const receiverAccMasked = isSender ? maskPhone(data.receiverAcc) : data.receiverAcc;
            container.innerHTML =   `
            <div class="w-100 position-relative">
            <span class="h4 card-title">${res.category} ${title}</span>
            <span class="card-text position-absolute" style="right:0" id="amount">${amountVal}</span>
          </div>
          <hr>
          <h5 class="card-title">Transaction Details</h5>
          <p class="card-text"><strong>Status:</strong> <span>${data.status}</span></p>
          <p class="card-text"><strong>Sender:</strong> <span>${data.senderName}</span></p>
          <p class="card-text"><strong>Reciever:</strong> <span>${data.receiverName}</span></p>
          <p class="card-text"><strong>Sender account:</strong> <span>${senderAccMasked}</span></p>
          <p class="card-text"><strong>Reciever account:</strong> <span>${receiverAccMasked}</span></p>
          <p class="card-text"><strong>Remark:</strong> <span>${data.remark}</span></p>
          <p class="card-text"><strong>Date:</strong> <span>${data.date}</span></p>
          <p class="card-text"><strong>ref:</strong> <span>${data.reference}</span></p>
          </div>
          <div class="card-footer text-muted">
              Thank you for using our service!
          </div>`;
              return;
    }if (res.category === "electricity") {
            container.innerHTML =   `
            <div class="w-100 position-relative">
            <span class="h4 card-title">${res.category}</span>
          </div>
          <hr>
          <h5 class="card-title">Transaction Details</h5>
          <p class="card-text"><strong>Status:</strong> <span>${data.status}</span></p>
          <p class="card-text"><strong>Customer Name:</strong> <span>${data.customer_name}</span></p>
          <p class="card-text"><strong>Distributor:</strong> <span>${data.distributor}</span></p>
          <p class="card-text"><strong>Meter Number:</strong> <span>${data.meter_number}</span></p>
          <p class="card-text"><strong>Meter Type:</strong> <span>${data.meter_type}</span></p>
          <p class="card-text"><strong>Purchased code:</strong> <span>${data.purchased_code}</span></p>
          <p class="card-text"><strong>Amount:</strong> <span>${data.amount}</span></p>
          <p class="card-text"><strong>Date:</strong> <span>${data.date}</span></p>
          <p class="card-text"><strong>Ref:</strong> <span>${data.reference}</span></p>
          </div>
          <div class="card-footer text-muted">
              Thank you for using our service!
          </div>`;
              return;
    }if (res.category === "deposit") {
      container.innerHTML =   `
      <div class="w-100 position-relative">
      <span class="h4 card-title">${res.category}</span>
    </div>
    <hr>
    <h5 class="card-title">Transaction Details</h5>
    <p class="card-text"><strong>Status:</strong> <span>${data.status}</span></p>
    <p class="card-text"><strong>Method:</strong> <span>${data.method}</span></p>
    <p class="card-text"><strong>Amount:</strong> <span>${data.amount}</span></p>
    <p class="card-text"><strong>Date:</strong> <span>${data.date}</span></p>
    <p class="card-text"><strong>Ref:</strong> <span>${data.reference}</span></p>
    </div>
    <div class="card-footer text-muted">
        Thank you for using our service!
    </div>`;
        return;
}
     else {
            container.innerHTML =   `
            <div class="w-100 position-relative">
            <span class="h4 card-title">${res.category}</span>
          </div>
          <hr>
          <h5 class="card-title">Transaction Details</h5>
          <p class="card-text"><strong>Status:</strong> <span>${data.status}</span></p>
          <p class="card-text"><strong>Customer Name:</strong> <span>${data.customer_name}</span></p>
          <p class="card-text"><strong>Cable name:</strong> <span>${data.cable_name}</span></p>
          <p class="card-text"><strong>Cable Number:</strong> <span>${data.cable_number}</span></p>
          <p class="card-text"><strong>Cable Plan:</strong> <span>${data.cable_plan}</span></p>
          <p class="card-text"><strong>Amount:</strong> <span>${data.amount}</span></p>
          <p class="card-text"><strong>Date:</strong> <span>${data.date}</span></p>
          <p class="card-text"><strong>Ref:</strong> <span>${data.reference}</span></p>
          </div>
          <div class="card-footer text-muted">
              Thank you for using our service!
          </div>`;
              return;
    }
    
 } catch (error) {
    console.error(error);
 }
}
displayTransaction()