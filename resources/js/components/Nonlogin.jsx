import { Inertia } from "@inertiajs/inertia";
import { Head, Link, usePage } from "@inertiajs/inertia-react";
import { Modal, Ripple, initMDB } from "../js/mdb.es.min";
import Swal from "sweetalert2";
import { useEffect, useState } from "react";

const Nonlogin = ({ children }) => {
    initMDB({ Modal, Ripple });
    Inertia.on("start", () => {
        let timerInterval;
        Swal.fire({
            title: "Tunggu ... ",
            // html: "I will close in <b></b> milliseconds.",
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        });
    });
    Inertia.on("finish", () => {
        Swal.close();
    });
    const { urlPrev } = usePage().props;
    return (
        <>
            <Head>
                <title>LOGIN M COMMUNITY</title>
            </Head>
            <header>
                <nav className="navbar navbar-expand-lg navbar-light bg-body-tertiary">
                    <div className="container-fluid"></div>
                    <div>
                        <img src="img/mcom.svg" width="50px" />
                    </div>
                </nav>
            </header>
            <div className="d-flex sub-bg align-items-center justify-content-center"></div>
            <div className="container sub-content bg-white">
                <div className="card">
                    <div className="card-body">{children}</div>
                </div>
            </div>
        </>
    );
};
export default Nonlogin;
