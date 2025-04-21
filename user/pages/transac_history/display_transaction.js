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

  loading = document.getElementById('loading')
  loading.style.display='block'
   const URLParams = new URLSearchParams(window.location.search);
   const catName   = URLParams.get('catname');
   const userId    = URLParams.get('uId');
   const transacId = URLParams.get('trId');
   console.log(transacId);
  async function displayTransaction(){
 try {
    const res = await sendRequest("GET",`./../user/pages/transac_history/processTransaction.php?catname=${catName}&uId=${userId}&trId=${transacId}`,);
    loading.style.display='none'
    console.log(res);
    if (res.category === 'data') {
        
    }
 } catch (error) {
    console.error(error);
 }
}
displayTransaction()