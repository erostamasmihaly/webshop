import React from 'react';
import ReactDOM from 'react-dom/client';

// Menü megjelenítése
const RenderMenu = () => {

    // Menü elemek felsorolása
    const menu = [
        { link: "list", name: "Termékek listája", btnclass: "btn-primary"},
        { link: "user", name: "Felhasználó adatai", btnclass: "btn-secondary"},
        { link: "payed", name: "Eddigi vásárlások", btnclass: "btn-primary"},
        { link: "cart", name: "Kosár tartalma", btnclass: "btn-secondary"},
        { link: "notification", name: "Értesítések", btnclass: "btn-secondary"},
    ];
  
    // Menü kirajzolása
    return (
        <div className="row">
        {menu.map((item,index) => (
            <div className="col-sm-3" key={index}>
                <a href={"/react/"+item.link}>
                    <button className={"btn "+item.btnclass+" w-100 m-1"}>{ item.name }</button>
                </a>
            </div>
        ))}
        </div>
    );
};

// Tartalom
function Main() {
    return (
        <div>
            <h1>REACT által készített alkalmazások</h1>
            <h2>A szürkével jelzett részek még nincsenek készen!</h2>
            <RenderMenu/>
        </div>
    );
}

// Tartalom betöltése
export default Main;

if (document.getElementById('main')) {
    const Index = ReactDOM.createRoot(document.getElementById("main"));

    Index.render(
        <React.StrictMode>
            <Main/>
        </React.StrictMode>
    )
}
