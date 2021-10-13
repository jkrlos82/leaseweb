export function getLocationList() {
    return fetch('http://localhost:8080/api/servers/filters/location')
      .then(data => data.json())
  }

export function getServersList(){
    return fetch('http://localhost:8080/api/servers')
      .then(data => data.json())
}

export function postFilters( filters ){ 
  console.log(filters);
  const requestOptions = {
    method: 'POST',
    headers: { 'Content-Type': 'application/json'},
    body: JSON.stringify({filters : filters})
  }
  return fetch('http://localhost:8080/api/servers/filters', requestOptions)
    .then(data => data.json())
}