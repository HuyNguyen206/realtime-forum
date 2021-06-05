import StorageApp from './storage'
import Token from './token'
import router from "./../router";
import EventBus from "../EventBus";
class User {
    repsonseLoginHandle(res){
        if (Token.isValid(res.data.access_token)) {
            StorageApp.storeToken(res.data)
            EventBus.$emit('isLogin', true)
            router.push({name: 'forum'})
        } else {
            alert('Token is invalid')
        }
    }
    hasValidToken() {
        let dataToken = StorageApp.getTokenData()
        return dataToken ? Token.isValid(dataToken.access_token) : false
    }

    loginAlready() {
        return this.hasValidToken()
    }

    userInfo() {
        return this.loginAlready() ? StorageApp.getTokenData().user : null
    }

    isAdmin(){
        let userInfo = this.userInfo()
        return userInfo ? userInfo.is_admin : false
    }

    isOwnQuestion(owner_id){
        let userInfo = this.userInfo()
        return userInfo ? owner_id == userInfo.id : false
    }

    logout(){
        StorageApp.clearToken()
    }
}

export default new User()
