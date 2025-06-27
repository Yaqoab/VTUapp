class Admin{
    constructor(){

    }
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
      elementById(id){
        return document.getElementById(id);
      }
      querySelector(selector) {
        return document.querySelector(selector);
      }
      querySelectorAll(selector) {
        return document.querySelectorAll(selector);
      }
            
      loader(){
        return this.elementById('loading');
      }
      login(){
        const logError = this.elementById('logError');
          const form   = this.elementById('adminLogin');
          const load   = this.loader();
          load.style.display="none";
  
          form.addEventListener('submit',async(event)=>{
             event.preventDefault();
             load.style.display="block"
             const formData = new FormData(form);
              
              try {
                const res = await this.sendRequest("POST",`./processlogin.php`,formData);
                load.style.display="none"
                console.log(res);
                if (res.status === "success") {
                  alertify.success(res.message);
                  setTimeout(()=>{
                    window.location.href = "../admin/index.php"; 
                  }, 2000)
                }else{
                  logError.textContent=res.message;
                }
              } catch (error) {
                console.error("login error:", error);
              }
            
  
          });
      }

          async  delete(table,userId,column) {
              if (!confirm("are you agree to delete?")) return;
            
              const formData = new FormData();
              formData.append("id", userId);
              formData.append('column', column)
              formData.append('table', table);
              try {
                const res = await admin.sendRequest("POST", "./deleteProcess.php", formData);
                if (res.status === "success") {
                  alert(res.message);
                  document.querySelector(`#user-row-${userId}`)?.remove();
                  window.location.reload();
                } else {
                  alert("Error: " + res.message);
                  console.log(res);
                }
              } catch (err) {
                alert("Unexpected error.");
                console.error(err);
              }
            }
          
                      //  ----------------open users---------------------

     async users(){
       const userscont = this.elementById("userstable");
       const form = this.elementById("editUserModal");
        try {
          const res = await this.sendRequest("GET",`./users/processUsers.php`);
          
          if (res.status === 'success') {
           let index = 1;
            res.data.forEach(user => {
              userscont.innerHTML += `
                <tr>
                  <td>${index++}</td>
                  <td>${user.username}</td>
                  <td>${user.email}</td>
                  <td>${user.phone}</td>
                  <td>${user.balance}</td>
                  <td><img src="./../uploads/${user.image === '' ? 'defaultpro.png' : user.image}" alt="User" width="50" class="img-thumbnail"></td>
                  <td>
                  <button type="button" class="dropdown-item text-primary" onclick="openEditModal(${user.user_id}, ${user.balance})">
                  Edit balance
                </button>
                  </td>
               
                </tr>
              `;
            });          

          }
          $('#usersTable').DataTable({
            pageLength: 10,     
            lengthChange: false, 
            ordering: true,     
            searching: true 
          });

          // Make sure this is globally available
          window.openEditModal = function (userId, currentBalance = 0) {
            document.getElementById('user_id').value = userId;
            document.getElementById('current_balance').value = currentBalance;
            document.getElementById('adjust_balance').value = ''; 
          
            $('#editUserModal').modal('show');
          };
          
        document.getElementById('editUserForm').addEventListener('submit', async  (e)=>{
          e.preventDefault();
        
          const id = document.getElementById('user_id').value;
          const adjustAmount = parseFloat(document.getElementById('adjust_balance').value);
          const currentBalance = parseFloat(document.getElementById('current_balance').value);
        
          if (isNaN(adjustAmount) || adjustAmount === 0) {
            alert("Please enter a valid amount (positive or negative).");
            return;
          }
        
          if (adjustAmount < 0) {
            const confirmRemove = confirm(`You're about to subtract ₦${Math.abs(adjustAmount)} from the user. Continue?`);
            if (!confirmRemove) return;
          }
                
          const formData = new FormData();
          formData.append('id', id);
          formData.append('adjust_balance', adjustAmount);
        
          try {
            const result = await this.sendRequest("POST",`./users/processUsers.php`,formData);
        
            if (result.status === 'success') {
              alert(result.message + ' New balance: ₦' + result.new_balance);
              $('#editUserModal').modal('hide');
            } else {
              alert(result.message || 'Update failed.');
            }
          } catch (err) {
            console.error(err);
            alert('Something went wrong.');
          }
        });
        
        
          
        } catch (error) {
          console.error(error);
        }

      }
                  //  ----------------close userrs---------------------

            //  ----------------open addPrice---------------------
      addPriceData() {
        const deletePlan = this.querySelectorAll(".deletePlan-btn");
        const deleteprice = this.querySelectorAll('.deleteprice-btn')
        const priceTable = this.elementById('priceTable')
    
        deletePlan.forEach(button => {
          button.addEventListener("click", () => {
            const planId = button.getAttribute("data-id");
            this.delete('dataplantype',planId,'plan_id'); // call reusable delete method
          });
        });

       deleteprice.forEach(btn =>{
        btn.addEventListener('click', () =>{
          const priceId = btn.getAttribute("price-id");
          this.delete("datapricelist",priceId,'id')
        })
       });
        document.getElementById('planForm').addEventListener('submit', async (e) => {
          e.preventDefault();
        
          const formData = new FormData(e.target); // use e.target instead of `this`
          const url = './dataPrice/processPlanName.php';
          try {
            const result = await this.sendRequest("POST", url, formData);
            console.log(result);
            alert(result.message);
            if (result.status === 'success') {
              location.reload();
            }
          } catch (err) {
            alert('An error occurred while saving.');
            console.error(err);
          
          }
        });
        
        this.elementById('priceForm').addEventListener('submit', async (e) => {
          e.preventDefault();
          const formData = new FormData(e.target);
        
          try {
          const result = await this.sendRequest("POST", './dataPrice/processDataPrice.php', formData);
        
            console.log(result);
            alert(result.message);
        
            if (result.status === 'success') {
              location.reload();
            }
          } catch (err) {
            alert('An error occurred while saving.');
            console.error(err);
          }
        });
        
        $('#priceTable').DataTable({
          pageLength: 10,     
          lengthChange: false, 
          ordering: true,     
          searching: true 
        });

       
      }
      openPlanModal() {
        const modal = new bootstrap.Modal( this.elementById('planModal'));
      
        this.elementById('planForm').reset();
        modal.show();
      }
      openPriceModal(price = null) {
        const modal = new bootstrap.Modal( this.elementById('priceModal'));
      
        this.elementById('priceForm').reset();
        
       
        this.elementById('id').value = price?.id || '';
        this.elementById('data_id').value = price?.data_id || '';
        this.elementById('plan_id').value = price?.plan_id || '';
        this.elementById('Amount').value = price?.Amount || '';
        this.elementById('size').value = price?.size || '';
        this.elementById('Validity').value = price?.Validity || '';
      
        modal.show();
      }
      
      
            //  ----------------close addPrice---------------------
            
            //  ----------------open tvcble---------------------

      tvCables(){
        document.getElementById('cableForm').addEventListener('submit', async function (e) {
          e.preventDefault();
          const formData = new FormData(this);
    
          try {
            const result = await this.sendRequest('POST','./TvCables/processtv.php',formData);
            alert(result.message);
            if (result.status === 'success') location.reload();
          } catch (err) {
            console.error(err);
            alert('An error occurred while saving.');
          }
        });
      }
      openCableModal(tv = null) {
        const modal = new bootstrap.Modal(this.elementById('cableModal'));
        this.elementById('cableForm').reset();
    
        this.elementById('cable_id').value = tv?.id || '';
        this.elementById('planName').value = tv?.planName || '';
        this.elementById('amount').value = tv?.amount || '';
        this.elementById('cableID').value = tv?.cableID || '';
        this.elementById('cablePlanID').value = tv?.cablePlanID || '';
    
        modal.show();
      }
    


                  //  ----------------close tvcables---------------------

      
}
const admin = new Admin();
    
window.admin = admin;

