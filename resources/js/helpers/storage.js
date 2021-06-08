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
         let token = JSON.parse(localStorage.getItem('token'))
        return token ? token.access_token : null
    }
}

export default new StorageApp ()
