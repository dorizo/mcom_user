import React, { Component } from "react";
import Subtemplate from "../components/Subtemplate";
import { Link } from "@inertiajs/inertia-react";

class Topupmenu extends Component {
    render() {
        return (
            <>
                <div className="d-flex sub-bg align-items-center justify-content-center">
                    <div className="sub-title fs-2">Topup WarungWA</div>
                </div>
                <div className="sub-content bg-white">
                    <div className="list-group list-group-light">
                        <Link
                            href="bcamanual"
                            className="list-group-item list-group-item-action px-3 border-0 pb-3 "
                            aria-current="true"
                        >
                            TOPUP MANUAL BCA
                            <i className="fa fa-arrow-right float-end position-absolute top-40 end-0"></i>
                        </Link>
                        <Link
                            href="bcamanual"
                            className="list-group-item list-group-item-action px-3 border-0 pb-3 "
                            aria-current="true"
                        >
                            TOPUP MANUAL BRI
                            <i className="fa fa-arrow-right float-end position-absolute top-40 end-0"></i>
                        </Link>
                        {/* <Link
                            href="#"
                            className="list-group-item list-group-item-action px-3 border-0  pb-3"
                        >
                            VIRTUAL AKUN MANDIRI
                            <i className="fa fa-arrow-right float-end position-absolute top-40 end-0"></i>
                        </Link>
                        <Link
                            href="#"
                            className="list-group-item list-group-item-action px-3 border-0  pb-3"
                        >
                            VIRTUAL AKUN BRI
                            <i className="fa fa-arrow-right float-end position-absolute top-40 end-0"></i>
                        </Link>
                        <Link
                            href="#"
                            className="list-group-item list-group-item-action px-3 border-0  pb-3"
                        >
                            VIRTUAL AKUN DOKU
                            <i className="fa fa-arrow-right float-end position-absolute top-40 end-0"></i>
                        </Link> */}
                    </div>
                </div>
            </>
        );
    }
}

Topupmenu.layout = (page) => <Subtemplate children={page} title="topup" />;
export default Topupmenu;
