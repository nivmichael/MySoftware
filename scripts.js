async function loadNames(e) {
  e.preventDefault();
  let url = 'action_page.php'
  let params = { country: '1' };

  const response = await fetch(url,  {
      method: 'POST',
      headers: {
          "Content-Type": "application/json",  // sent request
        },
      body: JSON.stringify(params)
  });

  const names = await response.json();

  console.log(names); 
}