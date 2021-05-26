class StorageApp {
     storeToken(data){
       localStorage.setItem('token', JSON.stringify(data))
    }
    getTokenData(){
       return JSON.parse(localStorage.getItem('token'))
    }
    clearToken(){
         localStorage.removeItem('token')
    }
    getToken(){
        return JSON.parse(localStorage.getItem('token')) .access_token
    }
}

export default new StorageApp ()
