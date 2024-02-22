import React, { Component } from 'react';
import {BrowserRouter as Router,Link,Route } from 'react-router-dom';
import Home from './Home';
import About from './About';
export default class Header extends Component {
    render() {
        return (
        	<Router>
	        	<div>
		            <nav className="navbar navbar-expand-lg navbar-light bg-light">
					  <div className="collapse navbar-collapse">
					    <ul className="navbar-nav mr-auto">
					      <li className="nav-item active">
					      	<Link className="nav-link" to="/">
					        	Home
				        	</Link>
					      </li>
					      <li className="nav-item">
					      	<Link className="nav-link" to="/about">About</Link>
					      </li>
					    </ul>
					  </div>
					</nav>
		           <Route exact path="/" component={Home} />
		           <Route exact path="/about" component={About} />	
	           </div>
            </Router>
        );
    }
}
