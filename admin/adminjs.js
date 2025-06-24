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

           // Delete user using sendRequest
          //  async  deleteUser(userId) {
          //   if (!confirm("Delete user and Monnify account?")) return;
          
          //   const formData = new FormData();
          //   formData.append("id", userId);
          
          //   try {
          //     const res = await admin.sendRequest("POST", "./delete.php", formData);
          //     if (res.status === "success") {
          //       alert(res.message);
          //       document.querySelector(`#user-row-${userId}`)?.remove();
          //     } else {
          //       alert("Error: " + res.message);
          //       console.log(res); // show full Monnify error
          //     }
          //   } catch (err) {
          //     alert("Unexpected error.");
          //     console.error(err);
          //   }
          // }
          
          
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
            pageLength: 10,      // show 10 users per page
            lengthChange: false, // hide the page size dropdown
            ordering: true,      // enable column sorting
            searching: true      // enable search box
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
  
      
      
}
const admin = new Admin();

window.admin = admin;

