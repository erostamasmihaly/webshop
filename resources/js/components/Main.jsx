import React from 'react';
import ReactDOM from 'react-dom/client';

const RenderMenu = props => {
    const menu = [
        { link: "list", name: "Termékek listája", btnclass: "btn-secondary"},
        { link: "user", name: "Felhasználó adatai", btnclass: "btn-secondary"},
        { link: "payed", name: "Eddigi vásárlások", btnclass: "btn-secondary"},
        { link: "cart", name: "Kosár tartalma", btnclass: "btn-secondary"},
        { link: "notification", name: "Értesítések", btnclass: "btn-secondary"},
    ];
  
    return (
        <div className="row">
        {menu.map((item,index) => (
            <div className="col-sm-3" key={index}>
                <button className={"btn "+item.btnclass+" w-100 m-1"}>{ item.name }</button>
            </div>
        ))}
        </div>
    );
};

function Main() {
    return (
        <div>
            <h1>REACT által készített alkalmazások</h1>
            <h2>A szürkével jelzett részek még mincsenek készen!</h2>
        </div>
    );
}

export default Main;

if (document.getElementById('main')) {
    const Index = ReactDOM.createRoot(document.getElementById("main"));

    Index.render(
        <React.StrictMode>
            <Main/>
            <RenderMenu/>
        </React.StrictMode>
    )
}
