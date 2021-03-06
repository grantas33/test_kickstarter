import React from 'react';
import { render } from 'react-dom';
import { slide as Menu } from 'react-burger-menu'
import { Switch, Route } from 'react-router-dom';

import SideMenu from './Components/Course/SideMenu/SideMenu';
import Home from './Components/Course/Home/Home';
import Notifications from './Components/Course/Notifications/Notifications';
import Schedule from './Components/Course/Schedule/Schedule';
import Lectures from './Components/Course/Lectures/Lectures';
import Homework from './Components/Course/Homework/Homework';
import LandingPage from './Components/Main/LandingPage/LandingPage';
import Login from './Components/Main/LoginRegister/Login';
import Register from './Components/Main/LoginRegister/Register';
import Main from './Components/Main/Main/Main';
import CreateNewCourse from './Components/Main/CreateNewCourse/CreateNewCourse';

class App extends React.Component {
    render(){
        return (
        <div>
            <Route path='/course' component={SideMenu}/>
            <Switch>
                <Route exact path='/' component={LandingPage}/>
                <Route exact path='/main' component={Main}/>
                <Route exact path='/main/create-new-course' component={CreateNewCourse}/>
                <Route path='/login' component={Login}/>
                <Route path='/register' component={Register}/>
                <Route exact path='/course/:course' component={Home}/>
                <Route path='/course/:course/notifications' component={Notifications}/>
                <Route path='/course/:course/schedule' component={Schedule}/>
                <Route path='/course/:course/lectures' component={Lectures}/>
                <Route path='/course/:course/homework' component={Homework}/>
            </Switch>  
        </div>               
        )
    }
}

export default App;