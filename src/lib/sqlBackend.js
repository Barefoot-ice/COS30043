import mariadb from "mariadb";

const pool = mariadb.createPool({
  host: "feenix-mariadb.swin.edu.au",
  user: "s105338913",
  password: "280905",
  connectionLimit: 5,
});

async function getConnection() {
  const connection = pool.getConnection();
  return connection;
}

async function makeQuery(query) {
  const connection = getConnection();

  let res;
  try {
    res = await connection.query(query);
    console.log(res);
  } finally {
    if (connection) (await connection).release();
  }

  return res;
}

export default makeQuery;
