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

  let currentPage = 1;
  let currentCatId = 'all'; // default
  const itemsPerPage = 2;
  const catContainer = document.getElementById("categories");
  const transContainer = document.getElementById("transcontainer");
  // const loading = document.getElementById('loading');
  // loading.style.display="block"
  function changePage(catId, newPage) {
    currentPage = newPage;
    getTransactionsByCategory(catId, newPage);
  }
  
  function renderPaginationControls(catId, page, totalCount) {
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";
  
    const totalPages = Math.ceil(totalCount / itemsPerPage); // 👈 calculate total pages
    const prevBtn = `<button class="btn category-selected m-1" ${page === 1 ? 'disabled' : ''} onclick="changePage('${catId}', ${page - 1})">Prev</button>`;
    const nextBtn = `<button class="btn category-selected m-1" ${page >= totalPages ? 'disabled' : ''} onclick="changePage('${catId}', ${page + 1})">Next</button>`;
  
    paginationContainer.innerHTML = `${prevBtn} <span>Page ${page} of ${totalPages}</span> ${nextBtn}`;
  }

  async function getTransactionsByCategory(catId, page) {
    const userId = id;
    const offset = (page - 1) * itemsPerPage;
    const url = `./../user/pages/transaction_table/transactionProcess.php?catId=${catId}&userId=${userId}&limit=${itemsPerPage}&offset=${offset}`;
  
    try {
      const response = await sendRequest("GET", url);
      if (response.status === "success") {
        const totalCountPage = response.totalCount;
        renderTransactions(response.data, transContainer);
        renderPaginationControls(catId, page, totalCountPage); // 👈 Pass total count
      }
    } catch (error) {
      console.error("Pagination error:", error);
    }
  }

  function renderTransactions(data, container){
  
    container.innerHTML="";
     if (data.length === 0) {
        container.innerHTML = `<p>No transactions records</p>`;
        return;
      }
     data.forEach((trans)=>{
       container.innerHTML +=`
            <div class="col-md-6 mx-auto mb-2 p-0 ">  
            <a href="index.php?page=pages/transac_history/transactions&catname=${trans.category}&uId=${trans.user_id}&trId=${trans.id}" class="card-link bt-1">
                <div class="card transaction-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h5 card-title">${trans.category} ${trans.transaction_type !== null || undefined ? trans.transaction_type : ""}</span><br>
                            <i class="card-text">${trans.date}</i>
                        </div>
                        <div class="text-right">
                            <span class="badge text-white" style="${trans.status === 'success' ? 'background:#6ccf6a' : 'background:#eb4c1a' }">${trans.status}</span><br>
                            <span class="fw-bold">${trans.amount}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
      `;
     });
     
  }

 
  // Function to initialize fetching of transactions and category data
async function getTransaction() {
  
  try {
    const res = await sendRequest("GET", `./../user/pages/transaction_table/transactionProcess.php?cat=cat`);

    if (res.status === "successful") {
      const cat = res.data;
      cat.forEach(element => {
        catContainer.innerHTML += `<div class="badge p-2 m-2 category-unselected cat" id="${element.cat_id}">${element.cat_name}</div>`;
      });
      const offset = (currentPage - 1) * itemsPerPage;
      const allTransactionsRes = await sendRequest("GET", `./../user/pages/transaction_table/transactionProcess.php?catId=all&userId=${id}&limit=${itemsPerPage}&offset=${offset}`);
      if (allTransactionsRes.status === "success") {
        await getTransactionsByCategory('all', 1);
      }
    }
  } catch (error) {
    console.error(error);
  }

  const categories = document.getElementsByClassName('cat');

  for (const cat of categories) {
    cat.addEventListener('click', async () => {
      currentPage = 1;  // Reset to page 1 when a new category is selected
      getTransactionsByCategory(cat.id, currentPage);

      // Highlight the selected category
      for (const cats of categories) {
        cats.classList.remove('category-selected');
      }
      cat.classList.remove('category-unselected');
      cat.classList.add('category-selected');
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  getTransaction();
});
  
