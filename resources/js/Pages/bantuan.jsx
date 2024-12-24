import React from "react";
import Subtemplate from "../components/Subtemplate";
import { Collapse, initMDB } from "../js/mdb.es.min";

function bantuan({ user, transaksi }) {
    initMDB({ Collapse });
    return (
        <>
            <div className="d-flex sub-bg align-items-center justify-content-center">
                <div className="sub-title fs-2">Halaman Bantuan</div>
            </div>
            <div className="container sub-content bg-white">
                <div className="card">
                    <div className="accordion" id="accordionExample">
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingOne">
                                <button
                                    data-mdb-collapse-init=""
                                    className="accordion-button"
                                    type="button"
                                    data-mdb-toggle="collapse"
                                    data-mdb-target="#collapseOne"
                                    aria-expanded="true"
                                    aria-controls="collapseOne"
                                >
                                    Tutorial Pengunaan Aplikasi
                                </button>
                            </h2>
                            <div
                                id="collapseOne"
                                className="accordion-collapse collapse show"
                                aria-labelledby="headingOne"
                                data-mdb-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <strong>
                                        Video Tutorial Pengunaan Aplikasi
                                    </strong>{" "}
                                    <iframe
                                        width="100%"
                                        height="400"
                                        src="https://www.youtube.com/embed/RDDE_kd3e_I?si=wW6U4nGi_0U2DwNO"
                                        title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingTwo">
                                <button
                                    data-mdb-collapse-init=""
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-mdb-toggle="collapse"
                                    data-mdb-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                >
                                    Tutorial Pengunaan Melaluai Whatsapp
                                </button>
                            </h2>
                            <div
                                id="collapseTwo"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingTwo"
                                data-mdb-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <strong>
                                        Video Tutorial Pengunaan Whatsapp
                                    </strong>{" "}
                                    <iframe
                                        width="100%"
                                        height="400"
                                        src="https://www.youtube.com/embed/RDDE_kd3e_I?si=wW6U4nGi_0U2DwNO"
                                        title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

bantuan.layout = (page) => <Subtemplate children={page} title="topup" />;
export default bantuan;
