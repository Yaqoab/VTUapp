//to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.getElementById("displayYear").innerHTML = currentYear;
}



function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(40.712775, -74.005973),
        zoom: 18,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}

class DomManipulator{
    constructor(){

    }
    elementById(id){
      return document.getElementById(id);
    }
}

class LoginAndRegister extends DomManipulator{
    constructor(){
      super();
    //   this.show();
    }

    loader(){
      return this.elementById('loading');
    }
    // ----------reference for making http request or sending data---------------
    sendAndRequest=(endPoint,method,data)=>{
        return new Promise((resolve,reject)=>{
          const http=new XMLHttpRequest();
          http.open(method,endPoint,true)
      
          http.addEventListener("load",()=>{
            if(http.readyState === 4)
             if(http.status === 200)
               resolve(JSON.parse(http.responseText))
               else
               reject({error:"error occur"})
               else
               reject({error:"error occur"})
          })
          method = method.toLowerCase();
          if (method === "post") {
            http.setHeaders={
              "Content-Type":"application/json",
              "Accept":"application/json"
            }
            http.send(data);
          }
          if (method === "get") {
            http.setHeaders={
              "Content-Type":"application/json",
              "Accept":"application/json"
            }
            http.send()
          }
        });
      }
        // ------------------user register--------------------
    register(){
        const form=this.elementById('form');
        const load=this.loader();
        const usernameErr=this.elementById('usernameErr');
        const emailErr=this.elementById('emailErr');
        const phoneErr=this.elementById('phoneErr');
        const passwordErr=this.elementById('passwordErr');
        const confirmErr=this.elementById('confirmErr');
        const urlParams=new URLSearchParams(window.location.search)
        const token=urlParams.get('referral')

    console.log(token);

        form.addEventListener('submit', (event)=> {
            event.preventDefault();
            load.style.display="block"
            const formData = new FormData(form);
            formData.append('referred_by',token);
            this.sendAndRequest("registerprocess.php","POST",formData)
           .then(res=>{
            console.log(res);
            load.style.display="none"
            if (res.status === "success") {
              alertify.success(res.message);
                setTimeout(function() {
                  // window.location.href = "login.php"; 
                }, 2000)
                usernameErr.textContent='';
                emailErr.textContent='';
                phoneErr.textContent='';
                passwordErr.textContent='';
                confirmErr.textContent='';
            }else{
              usernameErr.textContent=res.message.username;
              emailErr.textContent=res.message.email;
              phoneErr.textContent=res.message.phone;
              passwordErr.textContent=res.message.password;
              confirmErr.textContent=res.message.confirm;
            }
          
           })
           .then(error=>{
            console.log(error)
           })
           
          }); 
        
    }
    // -------------------login--------------------
    login(){
        const logError=this.elementById('logError');
        const form=this.elementById('loginForm');
        const load=this.loader();
        load.style.display="none"
        
        form.addEventListener('submit',(event)=>{
           event.preventDefault();
           load.style.display="block"
           const formData = new FormData(form);
            this.sendAndRequest("loginProcess.php","POST",formData)
            .then(res=>{
              load.style.display="none"
              if (res.status === "success") {
                alertify.success(res.message);
                setTimeout(()=>{
                  window.location.href = "user/index.php"; 
                }, 2000)
              }else{
                logError.textContent=res.message;
              }
              console.log(res);
            })

        });
    }

}

class MyApp extends LoginAndRegister{
  constructor(){
    super();
  }
  // ---------updating user data-----------------
  getEditUser(id){
    const form=this.elementById('editform');
    // inputs values
    const img=this.elementById('imageInput');
    const username=this.elementById('username');
    const email=this.elementById('email');
    const phone=this.elementById('phone')
    const load=this.loader();
   
    // errors text contenets
    const userError=this.elementById('userError');
    const emailError=this.elementById('emailError');
    const phoneError=this.elementById('phoneError');
    const imageError=this.elementById('imageError')
    
    this.sendAndRequest(`./../user/pages/settings/phpfiles/processEditUser.php?id=${id}`,"GET","")
    .then(res=>{
      
      if (res.status === "success") {
       let data=res.message;
       
        username.value=data.username;
        email.value=data.email;
        phone.value=data.phone
      }
    })
    .then(error=>{
      console.log(error)
    });
   
    form.addEventListener('submit',(event)=>{
      event.preventDefault();
      load.style.display="block"
      const formData = new FormData(form);
      const file = img.files[0];
      formData.append("image", file);
      formData.append("user_id", id);

      this.sendAndRequest("./../user/pages/settings/phpfiles/processEditUser.php","POST",formData)
      .then(res=>{
        load.style.display="none"
        if (res.status === "success") {
          alertify.success(res.message);
          setTimeout(()=>{
            window.history.back();
          }, 2000)
          userError.textContent="";
          emailError.textContent="";
          phoneError.textContent="";
          imageError.textContent="";
        }else{
          userError.textContent=res.message.username;
          emailError.textContent=res.message.email;
          phoneError.textContent=res.message.phone;
          imageError.textContent=res.message.image
        }
        

      })
      .then(error=>{
        console.log(error)
      });
    })

  }
// -------------updating or changing user password---------------------
  changePass(id){
    const form=this.elementById('password');
    const load=this.loader();
    const old=this.elementById('old')
    const newp=this.elementById('new');
    const confirm=this.elementById('confirm')

    form.addEventListener("submit", (e)=>{
      e.preventDefault();
      load.style.display="block"
      const formData=new FormData(form);
      formData.append('user_id',id)
      this.sendAndRequest("./../user/pages/settings/phpfiles/processPassword.php","POST",formData)
      .then(res=>{
        load.style.display="none"
        
        if (res.status === "success") {
          alertify.success(res.message);
          setTimeout(()=>{
            window.history.back();
          }, 2000)
          old.textContent='';
          newp.textContent='';
          confirm.textContent='';
        }else{
          old.textContent=res.message.old;
          newp.textContent=res.message.password;
          confirm.textContent=res.message.confirm;
        }
      })

    })
  }
  // ---------------add new transaction Pin--------------------
   newPin(id){
    const form=this.elementById('newpin');
    const password=this.elementById('passwordErr')
    const pin=this.elementById('pinErr')
    const confirm=this.elementById('confirmErr');
    const load=this.loader();

    // this.sendAndRequest(`./../user/pages/settings/phpfiles/newPin.php?id=${id}`,"GET","")
    // .then(res=>{
    //   // console.log(res);
    //   if (res.status === "success" && res.message ==="") {
    //     alertify.success("update your password");
    //   }
    // });

   form.addEventListener('submit',(e)=>{
      e.preventDefault();
      load.style.display="none"
      const formData=new FormData(form);
      formData.append('user_id',id)
      this.sendAndRequest("./../user/pages/settings/phpfiles/processNewPin.php","POST",formData)
      .then(res=>{
        load.style.display="none"
        console.log(res);
        if (res.status === "success") {
          alertify.success(res.message);
          setTimeout(()=>{
            window.location.href = "index.php";
            // window.history.back();
          }, 2000)
          password.textContent='';
          pin.textContent='';
          confirm.textContent='';
        }else{
          password.textContent=res.message.passwords;
          pin.textContent=res.message.pin;
          confirm.textContent=res.message.confirm;
        }
      });
   });    
   }
  //  ----------------change transaction pin--------------------
  changePin(id){
    const form=this.elementById('changePin')
    const oldPinErr=this.elementById('oldPinErr')
    const newPinErr=this.elementById('newPinErr')
    const confirmPinErr=this.elementById('confirmPinErr')
    const load=this.loader();
    
    this.sendAndRequest(`./../user/pages/settings/phpfiles/processChangePin.php?id=${id}`,"GET","")
    .then(res=>{
      // console.log(res);
      if (res.status === "success" && res.message ==="") {
        alertify.success("create your new transaction pin");
        setTimeout(function() {
        window.location.href = "index.php?page=pages/settings/newPin"; 
        },2000);
      }
    });

   
    form.addEventListener('submit',(e)=>{
      e.preventDefault();
      load.style.display="block"
      const formData=new FormData(form);
      formData.append('user_id',id)
      this.sendAndRequest("./../user/pages/settings/phpfiles/processChangePin.php","POST",formData)
      .then(res=>{
        load.style.display="none"
        if (res.status === "success") {
          alertify.success(res.message);
          setTimeout(()=>{
            window.history.back()
          },2000)
          oldPinErr.textContent='';
          newPinErr.textContent='';
          confirmPinErr.textContent='';
        }else{
          oldPinErr.textContent=res.message.oldPin;
          newPinErr.textContent=res.message.pin;
          confirmPinErr.textContent=res.message.confirm;
        }
        
      })
      
    })
  }
  // ------------forgot pin--------------
  forgotPin(id){
    const form=this.elementById('forgotpin');
    const email=this.elementById('emailErr');
    const load=this.loader();
    form.addEventListener('submit',(e)=>{
      e.preventDefault();
      
      load.style.display="block"
      const formData=new FormData(form);
      formData.append('user_id',id)
      this.sendAndRequest("./../user/pages/settings/phpfiles/processForgotPin.php","POST",formData)
      .then((res)=>{
        load.style.display="none"
        if (res.status === "success") {
          alertify.success(res.message);
          setTimeout(()=>{
            window.history.back()
          },2000);
          email.textContent='';
        }else{
          email.textContent=res.message.email
        }
      })
    });
  }
  // -------------------update forgot pin------------------------
  updateForgotPin(){
    const form=this.elementById('updatePin');
    const newPinErr=this.elementById('newPinErr');
    const confirmErr=this.elementById('confirmPinErr') 
    const expired=this.elementById('expired')
    const disableBtn=this.elementById('submit')
     const urlParams=new URLSearchParams(window.location.search)
     const token=urlParams.get('token')
   
     this.sendAndRequest(`../../../user/pages/settings/phpfiles/processUpdateForgotPin.php?token=${token}`,"GET","")
    .then(res=>{
      if (res.status === 'expired') {
        expired.textContent=res.message
        disableBtn.disabled=true
      }else{
        expired.textContent='';
      }
        
    });  
    
    form.addEventListener('submit',(e)=>{
      e.preventDefault();
      
      const formData=new FormData(form);      
      this.sendAndRequest("../../../user/pages/settings/phpfiles/processUpdateForgotPin.php","POST",formData)
      .then(res=>{
        if (res.status === "success") {
            alertify.success(res.message);
            setTimeout(()=>{
              window.history.back()
            },2000);
        }else{
          newPinErr.textContent=res.message.pin
          confirmErr.textContent=res.message.confirm
        }
        
      })
    })
   
  }
  // --------------------search user to transfer balance--------------------------
  searchUser(id){
    const searchInput=this.elementById('input');
    const searchResult=this.elementById('result')
    const load=this.loader();

    searchInput.addEventListener('input',()=>{
      
      const userId=id;
      const query=searchInput.value;
            searchResult.innerHTML='';
           
            if (query.trim() !=='' && query.length >=11) {
              load.style.display="block"
                this.sendAndRequest(`./../user/pages/transfer/processSearch.php?q=${query}&id=${userId}`,"GET","")
                .then(res=>{
                  load.style.display="none"
                  const userContainer = document.createElement('div');
                      userContainer.classList.add('container');
                  if (res.status === 'success') {
                    // console.log(res);
                    res.message.forEach(user => {
                      
                    userContainer.innerHTML=`
                    <a href="index.php?page=pages/transfer/transfer&id=${user.user_id}" class="user-card">
                    <img src="./../uploads/${user.image ? user.image : 'defaultpro.png'}" alt="User Image" >
                    <div>
                      <i class='text-success'>${user.username}</i>
                      <p class="text-sm">${user.phone}</p>
                    </div>
                  </a>
                    `;
                      searchResult.appendChild(userContainer);                 
                    });
                  }else{
                    userContainer.innerHTML = `
                    <span class='text-danger'>${res.message}</span>
                    `;
                    searchResult.appendChild(userContainer);
                  }
                    
                });  
            }
     })
  }
  // tarnsfer balance to another user
  transfer(id){
    const name=this.elementById('name')
    const phone=this.elementById('phone')
    const image=this.elementById('image')
    const form=this.elementById('transfer')
    const load=this.loader();
    const remarkInput=this.elementById('remark')
     const countDownElement=this.elementById('countDown')

    const amountErr=this.elementById('amountErr')
    const remarkErr=this.elementById('remarkErr')
    const pinErr=this.elementById('pinErr')

    const urlParams=new URLSearchParams(window.location.search)
     const recieverId=urlParams.get('id')
     const senderId=id
    this.sendAndRequest(`./../user/pages/transfer/processTransfer.php?id=${recieverId}`,"GET","")
    .then(res=>{
      
      if (res.status === 'success') {
        const user=res.message;
        name.textContent=user.username;
        phone.textContent=user.phone
        if(user.image !=="") image.src=`./../uploads/${user.image}`
        else image.src='./../uploads/defaultpro.png';
      }
    });

      

remarkInput.addEventListener('input', () => {
    const inputValue = remarkInput.value;
    const remainingCount = 50 - inputValue.length;
    
    updateCountDownDisplay(remainingCount);
});

function updateCountDownDisplay(remainingCount) {
    countDownElement.textContent = remainingCount >= 0 ? remainingCount : 0;
}
   
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        load.style.display="block";
        const formdata=new FormData(form)
        formdata.append('user_id',senderId);
        formdata.append('reciever_id',recieverId);
        this.sendAndRequest(`./../user/pages/transfer/processTransfer.php`,"POST",formdata)
        .then(res=>{
          load.style.display="none";
          if(res.pin ==''){
            alert("Go and set transaction pin");
             window.location.href = "index.php?page=pages/settings/newPin";
          }else{

          }

          if (res.status === 'success') {
            alertify.success(res.message);
            setTimeout(()=>{
              window.history.back()
            },2000);
            amountErr.textContent='';
            pinErr.textContent=''
          } else {
            amountErr.textContent=res.message.amount;
            pinErr.textContent=res.message.pin;

            if (res.status === 'failed') {
              alertify.success(res.message);
              setTimeout(()=>{
                window.history.back()
              },2000);
            }
          }
        })
    });
  }
  // --------------benefitiaries---------------
  benefitiaries(id){
    const benData=this.elementById('beneficiaries');
    const load=this.loader();
   
    const fetchAndRenderContainer=()=> {
      load.style.display='block';

        this.sendAndRequest(`./../user/pages/benefitiaries/processBenefitiaries.php?id=${id}`,'GET','')
    .then(res=>{
      load.style.display = 'none'; // Hide loading indicator
      const container = document.createElement('div');
      container.classList.add('container');
      container.setAttribute('id', 'ben-container');
      if (res.status === 'success') {
        
        res.message.forEach(ben=>{
          container.innerHTML += `
          <div class="user-card d-flex align-items-center p-3">
             <div class=' mr-5'>
                <span class="text-sm">${ben.phone}</span>  
             </div> 
                <span id='network' >${ben.network}</span>
                <input type="button" id="action-${ben.ben_id}" value="X" class="delete btn" onclick="return confirm('delete ?')">
              </div>`;
        });
        
        benData.innerHTML = ''; // Clear previous content
        benData.appendChild(container);

        container.addEventListener('click', (event) => {
          if (event.target.id.startsWith('action-')) {
              const benId = event.target.id.split('-')[1];
              const data = {
                user_id: id,
                ben_id: benId
              };
              this.sendAndRequest(`./../user/pages/benefitiaries/processBenefitiaries.php`, 'POST', JSON.stringify(data))
              .then(res => {
                console.log(res);
                // if (res.status === 'success') {
                   fetchAndRenderContainer();
                // }
                
              });
           }
      });
      }else {
        container.innerHTML = `<span class='text-danger text-center'>${res.message}</span>`;
         benData.innerHTML = '';
        benData.appendChild(container);
      }
    });

    }
    fetchAndRenderContainer()
    
  }
  // ----------------notification---------------
  notification(id){
    const notificationData=this.elementById('container');
    const load=this.loader();
    const userId = id;

    load.style.display='block'

    
    this.sendAndRequest(`./../user/pages/notification/processNotification.php?id=${id}`, 'GET','')
    .then(res=>{
      console.log(res);
      load.style.display='none'
      const row = document.createElement('div');
      row.classList.add('row');
      if (res.status === 'success') {
       
        res.message.forEach(notification=>{
          let link = "#"; // default if type not matched

          if (notification.type === 'transfer') {
              link = `index.php?page=pages/transac_history/transactions&catname=${notification.type}&uId=${notification.user_id}&ref=${notification.reference}`;
          } else if (notification.type === 'admin') {
              link = `index.php?page=pages/deposit_history&ref=${notification.reference}`;
          } else if (notification.type === 'airtime') {
              link = `index.php?page=pages/airtime_history&ref=${notification.reference}`;
          } else if (notification.type === 'admin') {
              link = `#`; // Maybe admin messages have no link
          }

          row.innerHTML +=`
          <div class="col-md-6 mx-auto mb-2">
          <a href="${link}" class="card-link">
              <div class="card ${notification.is_read == 0 ? 'nofication-unread' : 'nofication-read'}">
                  <div class="card-body">
                      <span class="h5 card-title">${notification.type}</span><br>
                      <div class="card-text">${notification.message}</div>
                      <i class="card-text">${notification.created_at}</i>
                  </div>
              </div>
          </a>
      </div>
          `;
          
        });
        notificationData.appendChild(row);
      } else {
        row.innerHTML = `<span class='h5 text-center'>${res.message}</span>`;
        notificationData.appendChild(row);
      }
      
    });
  }
  // ------------------ transfer reciept-------------------
  transferReciept(id){
    const transferTitle=this.elementById('transfertitle');
    const statuss=this.elementById('status');
    const sender=this.elementById('sender');
    const receiver=this.elementById('receiver');
    const senderAcc=this.elementById('senderacc');
    const remark=this.elementById('remark');
    const receiverAcc=this.elementById('receiveracc');
    const date=this.elementById('date');
    const amount=this.elementById('amount');

    const urlParams=new URLSearchParams(window.location.search)
    const ref=urlParams.get('ref')
    
    this.sendAndRequest(`./../user/pages/transac_history/phpFiles/processTransfer.php?user_id=${id}&ref_id=${ref}`, 'GET','')
    .then(res=>{
      console.log(res);
        if (res.status === 'success') {
             const val=res.message;
             const amountVal=val.sender_id == id ? `- ₦${val.amount}` :`+ ₦${val.amount}`;
             const title=val.sender_id == id ? `Send` :`Recieved`;

            transferTitle.textContent=title;
            amount.textContent=amountVal;
            statuss.textContent=val.status;
            sender.textContent=val.senderName;
            receiver.textContent=val.receiverName;
            senderAcc.textContent=val.senderAcc;
            receiverAcc.textContent=val.receiverAcc;
            remark.textContent=val.remark;
            date.textContent=val.timestamp;

        }
    });
    

  }
}

