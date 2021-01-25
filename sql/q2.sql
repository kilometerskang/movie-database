SELECT DISTINCT first, last
FROM Actor A, MovieActor M, Movie N
WHERE A.id=M.aid AND M.mid=N.id AND title="Die Another Day";